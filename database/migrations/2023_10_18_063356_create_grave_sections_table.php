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
        Schema::create('grave_sections', function (Blueprint $table) {
            $table->id();
            $table->string('SectionID');
            $table->string('CemeteryID'); // Keep it as a string
            $table->string('SectionCode');
            $table->string('TotalGraves');
            $table->string('AvailableGraves');
            $table->timestamps();

            // Define the foreign key relationship to the cemetery table
            $table->foreign('CemeteryID')->references('CemeteryID')->on('cemetery');
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
            $table->dropForeign(['CemeteryID']);
        });
        Schema::dropIfExists('grave_sections');
    }
};
