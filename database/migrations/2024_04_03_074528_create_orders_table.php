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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('UserId')->nullable();
            $table->unsignedInteger('CemeteryID'); // Adding foreign key column
            $table->string('SectionCode');
            $table->string('RowID');
            $table->unsignedInteger('GraveNum');
            $table->string('BuyerName');
            $table->string('Email')->nullable();
            $table->unsignedInteger('IdNumber');
            $table->unsignedInteger('PhoneNumber'); 




            $table->timestamps();

            $table->foreign('CemeteryID')->references('CemeteryID')->on('cemetery')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
