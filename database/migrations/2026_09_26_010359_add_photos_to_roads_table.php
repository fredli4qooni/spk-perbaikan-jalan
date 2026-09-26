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
        Schema::table('roads', function (Blueprint $table) {
            if (!Schema::hasColumn('roads', 'photos')) {
                $table->json('photos')->nullable()->after('photo');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('roads', function (Blueprint $table) {
            if (Schema::hasColumn('roads', 'photos')) {
                $table->dropColumn('photos');
            }
        });
    }
};
