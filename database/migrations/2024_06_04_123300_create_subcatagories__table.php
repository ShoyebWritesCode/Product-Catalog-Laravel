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
        Schema::create('subcatagories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer ('total');
            $table->timestamps();
            $table->foreignId('catagory_id')->constrained('catagories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcatagories');
    }
};
