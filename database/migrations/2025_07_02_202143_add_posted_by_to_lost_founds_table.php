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
            $table->integer('posted_by')->nullable()->after('founder_address');
            $table->string('poster_type')->default('guest')->after('posted_by'); // 'guest', 'user', 'admin'
            $table->ipAddress('poster_ip')->nullable()->after('poster_type');
        });

        Schema::table('lost_reports', function (Blueprint $table) {
            $table->integer('posted_by')->nullable()->after('description');
            $table->string('poster_type')->default('guest')->after('posted_by');
            $table->ipAddress('poster_ip')->nullable()->after('poster_type');
        });

        Schema::table('messages', function (Blueprint $table) {
            $table->integer('posted_by')->nullable()->after('message');
            $table->string('poster_type')->default('guest')->after('posted_by');
            $table->ipAddress('poster_ip')->nullable()->after('poster_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
