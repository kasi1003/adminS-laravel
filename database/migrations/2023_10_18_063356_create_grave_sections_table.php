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
            $table->string('CemeteryID');
            $table->string('SectionCode');
            $table->string('TotalGraves');
            $table->string('AvailableGraves');
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
        Schema::dropIfExists('grave_sections');
    }
};
