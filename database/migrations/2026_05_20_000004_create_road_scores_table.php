<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('road_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('road_id')->constrained('roads')->cascadeOnDelete();
            $table->foreignId('criterion_id')->constrained('criteria')->cascadeOnDelete();
            $table->decimal('value', 10, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['road_id', 'criterion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('road_scores');
    }
};
