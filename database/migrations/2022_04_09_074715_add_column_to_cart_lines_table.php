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
        Schema::table('cart_lines', function (Blueprint $table) {
            $table->string('coffee_name', 50);
            $table->string('coffee_brand', 50);
            $table->string('coffee_type', 50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_lines', function (Blueprint $table) {
            $table->dropColumn('coffee_name');
            $table->dropColumn('coffee_brand');
            $table->dropColumn('coffee_type');
        });
    }
};
