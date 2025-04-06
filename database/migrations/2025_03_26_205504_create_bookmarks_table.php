<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relationship columns
            $table->unsignedBigInteger('bookmarkable_id');
            $table->string('bookmarkable_type'); // 'App\Models\Job' or 'App\Models\Tender'

            $table->timestamps();

            // Prevent duplicate bookmarks
            $table->unique(['user_id', 'bookmarkable_id', 'bookmarkable_type']);
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('bookmarks');
    }
};
