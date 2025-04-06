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
            'item_type' => 'required|in:job,tender'
        ]);

        $user = auth()->user();
        $model = $request->item_type === 'job'
            ? 'App\Models\Job'
            : 'App\Models\Tender';

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

    public function show()
    {
       $data['bookmarks']= Bookmark::where('user_id', auth()->id())->get();
       return view('bookmarks.view', $data);

    }
}
