<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attributes', function (Blueprint $table) {

            $table->string('field_type')
                  ->default('dropdown')
                  ->after('slug');

        });
    }

    public function down(): void
    {
        Schema::table('attributes', function (Blueprint $table) {

            $table->dropColumn('field_type');

        });
    }
};