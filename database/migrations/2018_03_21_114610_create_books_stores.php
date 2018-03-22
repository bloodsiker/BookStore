<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksStores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_stores', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('book_id')->unsigned();
            $table->integer('store_id')->unsigned();
            $table->integer('quantity');

            $table->foreign('book_id')
                ->references('id')->on('books')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('store_id')
                ->references('id')->on('stores')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_stores');
    }
}
