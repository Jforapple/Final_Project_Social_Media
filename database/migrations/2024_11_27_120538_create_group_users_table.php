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
        Schema::create('group_users', function (Blueprint $table) {
            $table->id();
            $table->string('status', 25); // approved, pending
            $table->string('role', 25); // admin, user
            $table->string('token', 1024)->nullable();
            $table->timestamp('token_expire_date')->nullable();
            $table->timestamp('token_used')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('group_id')->constrained('groups');
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop the foreign key constraints first
        Schema::table('group_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);    // Drop the foreign key from the 'user_id' column
            $table->dropForeign(['group_id']);   // Drop the foreign key from the 'group_id' column
            $table->dropForeign(['created_by']); // Drop the foreign key from the 'created_by' column
        });

        // Now drop the group_users table
        Schema::dropIfExists('group_users');
    }
};
