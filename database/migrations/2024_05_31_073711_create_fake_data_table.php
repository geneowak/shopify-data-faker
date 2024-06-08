<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fake_data', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shopify_id')->unique();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fake_products');
    }
};
