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
        Schema::create('burial_records', function (Blueprint $table) {
            $table->id();
            $table->string('CemeteryID'); // Keep it as a string
            $table->string('SectionCode');
            $table->string('CemeteryName'); // Keep it as a string
            $table->string('GraveNumber');
            $table->string('Surname');
            $table->string('Name'); // Keep it as a string
            $table->date('DateOfBirth');
            $table->string('DeathNumber'); // Keep it as a string
            $table->date('DateOfDeath');
            $table->timestamps();

            $table->foreign('CemeteryID')->references('CemeteryID')->on('cemetery');
            $table->foreign('SectionCode')->references('SectionCode')->on('grave_sections');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('grave_sections', function (Blueprint $table) {
            $table->dropForeign(['SectionCode']);
        });
        Schema::table('cemetery', function (Blueprint $table) {
            $table->dropForeign(['CemeteryID']);
        });
        Schema::dropIfExists('burial_records');
    }
};
