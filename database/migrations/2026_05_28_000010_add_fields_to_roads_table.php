<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            $table->decimal('length', 10, 2)->nullable()->after('photo'); // panjang jalan rusak (m)
            $table->decimal('width', 8, 2)->nullable()->after('length'); // lebar jalan (m)
            $table->integer('holes_count')->nullable()->after('width'); // banyaknya lubang
            $table->json('potholes_data')->nullable()->after('holes_count'); // data dimensi lubang
            $table->string('importance')->nullable()->after('potholes_data'); // kepentingan jalan (sekolah/pasar/kantor)
            $table->decimal('distance', 8, 2)->nullable()->after('importance'); // jarak jalan dari kantor dinas (km)
            $table->decimal('latitude', 10, 8)->nullable()->after('distance'); // peta lat
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude'); // peta lng
        });
    }

    public function down(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'holes_count', 'potholes_data', 'importance', 'distance', 'latitude', 'longitude']);
        });
    }
};
