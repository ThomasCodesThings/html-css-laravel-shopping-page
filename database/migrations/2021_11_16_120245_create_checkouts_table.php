<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->integer('userID')->unsigned()->nullable();
            $table->integer('cartID')->unsigned()->nullable();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('country');
            $table->string('region');
            $table->string('town');
            $table->string('postalCode');
            $table->string('street');
            $table->string('details')->nullable();
            $table->string('payment');
            $table->string('delivery');
            $table->string('total');

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
        Schema::dropIfExists('checkouts');
    }
}
