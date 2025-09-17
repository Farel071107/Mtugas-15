<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relasi ke tabel users
            $table->string('title'); // kolom judul tugas
            $table->text('description')->nullable(); // deskripsi opsional
            $table->boolean('is_completed')->default(false); // status tugas
            $table->timestamps(); // created_at & updated_at
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
