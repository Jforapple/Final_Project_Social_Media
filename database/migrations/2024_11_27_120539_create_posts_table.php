<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the table if it exists
        Schema::dropIfExists('posts');

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->longText('body')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('group_id')->nullable()->constrained('groups');
            $table->foreignId('deleted_by')->nullable()->constrained('users');
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraints first
        Schema::table('posts', function (Blueprint $table) {
            $table->dropForeign(['user_id']);    // Drop the foreign key from the 'user_id' column
            $table->dropForeign(['group_id']);   // Drop the foreign key from the 'group_id' column
            $table->dropForeign(['deleted_by']); // Drop the foreign key from the 'deleted_by' column
        });

        // Now drop the posts table
        Schema::dropIfExists('posts');
    }
};
