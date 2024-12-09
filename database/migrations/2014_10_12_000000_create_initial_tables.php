<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInitialTables extends Migration
{
    public function up()
    {
        // Create users table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'user'])->default('user');
            $table->timestamps();
        });
        // Create categories table
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
        // Create records table
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('holder');
            $table->string('value');
            $table->date('record_date');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); # A MODIFIER QUAND IL Y AURA LE CAS
            $table->timestamps();
        });
        // Create previous_records table
        Schema::create('previous_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('original_record_id')->constrained('records')->onDelete('cascade');
            $table->string('title');
            $table->string('holder');
            $table->string('value');
            $table->date('record_date');
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('previous_records');
        Schema::dropIfExists('records');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('users');
    }
}
