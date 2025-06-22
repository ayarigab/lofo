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
        Schema::table('lost_founds', function (Blueprint $table) {
            $table->string('slug')->unique()->after('title');
            $table->string('color')->nullable()->after('category_id');
            $table->string('brand')->nullable()->after('description');
            $table->string('model')->nullable()->after('brand');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lost_founds', function (Blueprint $table) {
            //
        });
    }
};
