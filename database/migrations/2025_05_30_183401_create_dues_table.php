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
        Schema::create('dues', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->decimal('amount', 8, 2);
            $table->date('payment_date');
            $table->integer('year');
            $table->string('payment_method');
            $table->foreign('member_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('created_at')->nullable();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dues');
    }
};
