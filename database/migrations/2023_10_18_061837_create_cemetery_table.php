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
            $table->id();
            $table->string('CemeteryID')->nullable();
            $table->string('Region')->nullable();
            $table->string('CemeteryName')->nullable();
            $table->string('Town')->nullable();
            $table->string('NumberOfSections')->nullable();
            $table->string('TotalGraves')->nullable();
            $table->string('AvailableGraves')->nullable();

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
        Schema::dropIfExists('cemetery');
    }
};
