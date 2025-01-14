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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_hotel')->constrained('hotels')->onDelete('cascade');
            $table->foreignId('id_type_room')->constrained('room_types')->onDelete('cascade');
            $table->foreignId('id_accommodation')->constrained('accommodations')->onDelete('cascade');
            $table->unique(['id_hotel', 'id_type_room', 'id_accommodation'], 'unique_room_type_accommodation');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
