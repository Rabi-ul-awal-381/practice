<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Change the column type to plain string to allow any value like 'pending'
            $table->string('membership_type')->default('free')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Optional rollback (if you had enum before)
            $table->enum('membership_type', ['free', 'paid', 'premium'])->default('free')->change();
        });
    }
};
