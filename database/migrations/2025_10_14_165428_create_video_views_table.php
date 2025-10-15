<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    

public function up(): void
{
    Schema::create('video_views', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('video_id')->constrained()->onDelete('cascade');
        $table->timestamp('viewed_at')->nullable(); // From your $fillable array
        $table->timestamps(); // Standard created_at and updated_at columns
    });
}

    public function down(): void
    {
        Schema::dropIfExists('video_views');
    }
};
