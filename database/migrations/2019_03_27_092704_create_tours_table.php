<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('image')->nullable();
            $table->text('city')->nullable();
            $table->string('duration')->nullable();
            $table->string('season')->nullable();
            $table->string('category')->nullable();
            $table->string('max_qty_tourists')->nullable();
            $table->string('schedule')->nullable();
            $table->string('cost')->nullable();
            $table->text('program')->nullable();
            $table->text('include_service')->nullable();
            $table->text('include_guide')->nullable();
            $table->text('include_transport')->nullable();
            $table->text('include_food')->nullable();
            $table->text('conditions')->nullable();
            $table->text('ad_service')->nullable();
            $table->text('ad_guide')->nullable();
            $table->text('ad_transport')->nullable();
            $table->text('ad_food')->nullable();
            $table->text('route')->nullable();
            $table->text('country')->nullable();
            $table->integer('join_group')->nullable();
            $table->text('include_accommodations')->nullable();
            $table->date('hot')->nullable();
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
        Schema::dropIfExists('tours');
    }
}
