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
    Schema::create('courses', function (Blueprint $table) {
        $table->id();
        $table->foreignId('semester_id')->constrained()->onDelete('cascade');
        $table->string('code'); // Kode MK
        $table->string('name'); // Nama MK
        $table->integer('credits'); // SKS
        $table->string('type'); // Sifat: Wajib/Pilihan
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
