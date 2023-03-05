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
        Schema::create('attch_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('file');
            $table->string('size');
            $table->unsignedBigInteger('room_id');
            $table->foreign("room_id")->references('id')->on('rooms')->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attch_rooms');
    }
};
