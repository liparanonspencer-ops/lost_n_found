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
    Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Use $table->string() to define the column name in the database
        $table->string('item_name'); 
       
        $table->text('description');
        $table->enum('type', ['lost', 'found']);
        $table->string('category');
        $table->string('location');
        $table->string('image_path')->nullable();
        $table->boolean('is_resolved')->default(0);
        $table->boolean('is_rejected')->default(0); // New column for rejection status
        $table->string('status')->default('available');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
