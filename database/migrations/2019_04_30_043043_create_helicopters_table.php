<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHelicoptersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('helicopters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category')->nullable();
            $table->date('date')->nullable();
            $table->string('title')->nullable();
            $table->string('cost')->nullable();
            $table->text('place')->nullable();
            $table->integer('max_qty_tourists')->nullable();
            $table->integer('tour_id')->nullable();
            $table->string('lang')->nullable();
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
        Schema::dropIfExists('helicopters');
    }
}
