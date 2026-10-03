<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $t) {
            $t->id();
            $t->string('meal_id', 20)->unique();
            $t->string('name');
            $t->string('image')->nullable();
            $t->string('category', 100)->nullable();
            $t->string('area', 100)->nullable();
            $t->text('instructions')->nullable();
            $t->text('ingredients');
            $t->decimal('price', 8, 2);
            $t->string('status', 10)->default('ada');
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
