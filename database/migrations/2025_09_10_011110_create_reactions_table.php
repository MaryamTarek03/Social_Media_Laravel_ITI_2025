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
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('reaction_type_id')->constrained()->cascadeOnDelete();
            $table->morphs('reactable');
            $table->timestamps();

            // Unique constraint to prevent duplicate reactions
            $table->unique(['user_id', 'reaction_type_id', 'reactable_id', 'reactable_type'], 'unique_user_reaction');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reactions');
    }
};
