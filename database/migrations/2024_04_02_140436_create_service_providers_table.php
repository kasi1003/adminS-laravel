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
        Schema::create('service_providers', function (Blueprint $table) {
            $table->id();
            $table->string('Name'); // Adding varchar column for section code
            $table->string('Motto');
            $table->string('Email');
            $table->unsignedInteger('ContactNumber');

            $table->unsignedInteger('TotalBurials');
            $table->unsignedInteger('SuccessfulBurials');
            $table->unsignedInteger('UnsuccessfulBurials');


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
        Schema::dropIfExists('service_providers');
    }
};
