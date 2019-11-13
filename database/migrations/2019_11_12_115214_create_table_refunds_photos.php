<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRefundsPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refunds_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('refund_id');

            $table->text('image');
            $table->timestamps();

            $table->foreign('refund_id')->references('id')->on('refunds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refunds_photos');
    }
}
