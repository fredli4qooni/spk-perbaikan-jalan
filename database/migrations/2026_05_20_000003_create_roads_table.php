<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('location');
            $table->year('survey_year');
            $table->string('kelurahan');
            $table->string('kecamatan');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // 5 Nilai Kriteria Dropdown (Skala 1 - 5)
            $table->unsignedTinyInteger('c1_panjang')->default(1);
            $table->unsignedTinyInteger('c2_lebar')->default(1);
            $table->unsignedTinyInteger('c3_kedalaman')->default(1);
            $table->unsignedTinyInteger('c4_lubang')->default(1);
            $table->unsignedTinyInteger('c5_kepentingan')->default(1);

            $table->string('photo')->nullable();
            $table->string('video')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roads');
    }
};
