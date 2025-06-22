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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description');
            $table->boolean('active')->default(true);
            $table->timestamps();
        });

        Schema::create('lost_founds', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('found_location')->nullable();
            $table->date('found_date')->nullable();
            $table->string('founder_name');
            $table->string('status')->default('pending');
            $table->string('founder_email')->nullable();
            $table->string('founder_phone');
            $table->string('founder_address')->nullable();
            $table->string('image');
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->timestamps();
        });

        Schema::create('claimers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('full_name');
            $table->text('location')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->timestamps();
        });

        Schema::create('lost_reports', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone');
            $table->string('items_lost');
            $table->date('lost_date')->nullable();
            $table->string('lost_location')->nullable();
            $table->text('description');
            $table->timestamps();
        });

        Schema::create('claimed_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lost_found_id')->constrained('lost_founds')->onDelete('cascade');
            $table->foreignId('claimer_id')->constrained('claimers')->onDelete('cascade');
            $table->text('claimer_message')->nullable();
            $table->boolean('is_claimed')->default(false);
            $table->timestamp('claimed_at')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('id_proof_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
        Schema::dropIfExists('lost_founds');
        Schema::dropIfExists('claimers');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('lost_reports');
        Schema::dropIfExists('claimed_items');
    }
};
