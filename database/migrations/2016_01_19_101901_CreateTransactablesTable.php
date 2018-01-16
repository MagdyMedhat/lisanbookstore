<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactables', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('quantity')->unsigned();
            $table->integer('transaction_id')->unsigned()->index();
            $table->integer('transactable_id')->unsigned()->index();
            $table->string('transactable_type');
        });
//        Schema::table('transactables', function (Blueprint $table){
//            $table->foreign('transaction_id')->references('id')->on('Transacations')->onDelete('cascade');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('transactables');
    }
}
