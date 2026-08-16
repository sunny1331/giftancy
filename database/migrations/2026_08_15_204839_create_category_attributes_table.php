<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('category_attributes', function (Blueprint $table) {

            $table->id();

            $table->foreignId('category_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('attribute_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->integer('sort_order')->default(0);

            $table->boolean('show_in_short_description')->default(true);

            $table->boolean('show_in_specifications')->default(true);

            $table->boolean('is_required')->default(false);

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_attributes');
    }
};