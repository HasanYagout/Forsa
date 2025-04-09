<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Job;
use App\Models\Tender;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function toggle(Request $request)
    {
        $request->validate([
            'item_id' => 'required|integer',
            'item_type' => 'required|in:job,tender,training'
        ]);

        $user = auth()->user();
        $model = match($request->item_type) {
            'job' => 'App\Models\Job',
            'tender' => 'App\Models\Tender',
            'training' => 'App\Models\Training',
            default => throw new \InvalidArgumentException('Invalid item type')
        };

        // Check if bookmark exists
        $bookmark = $user->bookmarks()
            ->where('bookmarkable_id', $request->item_id)
            ->where('bookmarkable_type', $model)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
        } else {
            $user->bookmarks()->create([
                'bookmarkable_id' => $request->item_id,
                'bookmarkable_type' => $model
            ]);
            $bookmarked = true;
        }

        return response()->json([
            'success' => true,
            'bookmarked' => $bookmarked
        ]);
    }

    // Controller
    public function show()
    {
        $data = [
            'jobBookmarks' => Bookmark::with('bookmarkable')
                ->where('user_id', auth()->id())
                ->where('bookmarkable_type', 'App\Models\Job')
                ->get(),
//            'tenderBookmarks' => Bookmark::with('bookmarkable')
//                ->where('user_id', auth()->id())
//                ->where('bookmarkable_type', 'App\Models\Tender')
//                ->get(),
            'trainingBookmarks' => Bookmark::with('bookmarkable')
                ->where('user_id', auth()->id())
                ->where('bookmarkable_type', 'App\Models\Training')
                ->get()
        ];
        return view('bookmarks.view', $data);
    }
}
