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
        Schema::table('orderItems', function (Blueprint $table) {
            $table->foreignId('size_id')->nullable()->constrained('sizes');
            $table->foreignId('color_id')->nullable()->constrained('colors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orderitems', function (Blueprint $table) {
            //
        });
    }
};
