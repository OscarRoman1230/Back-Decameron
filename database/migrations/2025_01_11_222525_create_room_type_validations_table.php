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
        Schema::create('room_type_validations', function (Blueprint $table) {
            $table->foreignId('id_type_room')->constrained('room_types')->onDelete('cascade');
            $table->foreignId('id_accommodation')->constrained('accommodations')->onDelete('cascade');
            $table->primary(['id_type_room', 'id_accommodation']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_type_validations');
    }
};
