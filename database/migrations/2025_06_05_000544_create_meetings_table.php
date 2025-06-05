<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('datetime');
            $table->tinyInteger('status')->default(0);
            $table->string('location')->nullable();

            $table->foreignId('association_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organizer_id')->constrained('users')->cascadeOnDelete(); // Corrected

            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
