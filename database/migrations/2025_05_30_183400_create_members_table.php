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
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->nullable()->unique();
            $table->text('password');
            $table->string('phone');
            $table->enum('role', ['admin', 'membre', 'super_admin']);
            $table->text('availability')->nullable();
            $table->text('skills')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('is_admin')->default(false);
            $table->string('profile_photo')->nullable(); 
            $table->rememberToken();
            $table->uuid('association_id');
            $table->foreign('association_id')->references('id')->on('associations')->onDelete('cascade');
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
