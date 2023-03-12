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
            $table->string('name');
            $table->timestamp('time_start')->default(date("Y-m-d H:i:s"));
            $table->timestamp('time_end')->default(date("Y-m-d H:i:s"));
            $table->string("kelas");
            $table->string("mata_kuliah");
            $table->string('folder', 50)->unique();
            $table->string('extensions');
            $table->boolean('type_field')->default(false);
            $table->boolean('status')->default(false);
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
