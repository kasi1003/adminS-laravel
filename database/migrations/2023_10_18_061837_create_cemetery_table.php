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
        Schema::create('cemetery', function (Blueprint $table) {
            $table->increments('CemeteryID'); // Adding auto-increment primary key
            $table->string('CemeteryName')->nullable();
            $table->unsignedInteger('Town')->nullable();
            $table->string('NumberOfSections')->nullable();
            $table->string('TotalGraves')->nullable();
            $table->string('AvailableGraves')->nullable();
            $table->binary('SvgMap')->nullable(); // Adding blob column for SVG map, allowing NULL values
            $table->timestamps();

            $table->foreign('Town')->references('town_id')->on('towns')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cemetery');
    }
};
