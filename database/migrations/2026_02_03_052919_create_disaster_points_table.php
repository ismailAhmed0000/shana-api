<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disaster_points', function (Blueprint $table) {
            $table->id();
            $table->enum('type', [
                'flood',
                'storm',
                'earthquake',
                'fire',
            ]);
            $table->longText('description');
            // $table->enum('status', ['sufficient', 'insufficient', 'critical']);
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disaster_points');
    }
};
