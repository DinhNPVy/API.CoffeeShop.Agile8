<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('coffees');
        Schema::create('coffees', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->string("image", 255);
            $table->string("price", 255);
            $table->smallInteger("status");
            $table->foreignId('brand')->constrained('coffee_brands');
            $table->foreignId('type')->constrained('coffee_types');
            $table->text("description");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coffees');
        Schema::create('coffees', function (Blueprint $table) {
            $table->id();
            $table->string("name", 50);
            $table->string("image", 255);
            $table->string("price", 255);
            $table->integer("type");
            $table->smallInteger("status");
            $table->integer("brand");
            $table->text("description");
            $table->timestamps();
        });
    }
};
