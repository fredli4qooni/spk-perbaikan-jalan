<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            if (!Schema::hasColumn('roads', 'name')) {
                $table->string('name')->nullable()->after('user_id');
            }
            if (!Schema::hasColumn('roads', 'latitude')) {
                $table->decimal('latitude', 10, 8)->nullable()->after('kecamatan');
            }
            if (!Schema::hasColumn('roads', 'longitude')) {
                $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            }
            if (!Schema::hasColumn('roads', 'c1_panjang')) {
                $table->unsignedTinyInteger('c1_panjang')->default(1)->after('longitude');
            }
            if (!Schema::hasColumn('roads', 'c2_lebar')) {
                $table->unsignedTinyInteger('c2_lebar')->default(1)->after('c1_panjang');
            }
            if (!Schema::hasColumn('roads', 'c3_kedalaman')) {
                $table->unsignedTinyInteger('c3_kedalaman')->default(1)->after('c2_lebar');
            }
            if (!Schema::hasColumn('roads', 'c4_lubang')) {
                $table->unsignedTinyInteger('c4_lubang')->default(1)->after('c3_kedalaman');
            }
            if (!Schema::hasColumn('roads', 'c5_kepentingan')) {
                $table->unsignedTinyInteger('c5_kepentingan')->default(1)->after('c4_lubang');
            }
            if (!Schema::hasColumn('roads', 'video')) {
                $table->string('video')->nullable()->after('photo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            $columns = [
                'c1_panjang', 'c2_lebar', 'c3_kedalaman', 
                'c4_lubang', 'c5_kepentingan', 
                'video'
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('roads', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
