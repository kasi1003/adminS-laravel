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
        Schema::create('grave', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('CemeteryID'); // Adding foreign key column
            $table->string('SectionCode');
             // Adding varchar column for section code
            $table->unsignedInteger('GraveNum');
            $table->tinyInteger('GraveStatus');
            $table->unsignedInteger('TotalGraves'); // Adding int column for total graves
            $table->unsignedInteger('AvailableGraves'); // Adding int column for available graves
            $table->string('BuriedPersonsName');
            $table->date('DateOfBirth');
            $table->date('DateOfDeath');
            $table->string('DeathCode');

            $table->timestamps(); 

            $table->foreign('CemeteryID')->references('CemeteryID')->on('cemetery')->onDelete('cascade');
            $table->foreign('SectionCode')->references('SectionCode')->on('grave_sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grave');
    }
};
