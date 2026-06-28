<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            $table->decimal('length', 10, 2)->nullable()->after('photo'); // panjang jalan (m)
            $table->decimal('width', 8, 2)->nullable()->after('length'); // lebar jalan (m)
            $table->integer('holes_count')->nullable()->after('width'); // banyaknya lubang
            $table->decimal('hole_depth', 8, 2)->nullable()->after('holes_count'); // kedalaman lubang (cm)
            $table->string('importance')->nullable()->after('hole_depth'); // kepentingan jalan (sekolah/pasar/kantor)
        });
    }

    public function down(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'holes_count', 'hole_depth', 'importance']);
        });
    }
};
