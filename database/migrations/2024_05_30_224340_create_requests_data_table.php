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
        Schema::create('requests_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('be_author_request_id')->nullable()->references('id')->on('be_author_requests')->onDelete('cascade');
            $table->string('country');
            $table->string('address');
            $table->string('files_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests_data');
    }
};
