<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('account_requests', function (Blueprint $table) {
            $table->string('processed_password')->nullable()->after('processed_notes');
        });
    }

    public function down(): void
    {
        Schema::table('account_requests', function (Blueprint $table) {
            $table->dropColumn('processed_password');
        });
    }
};
