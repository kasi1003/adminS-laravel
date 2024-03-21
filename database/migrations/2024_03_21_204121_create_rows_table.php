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
        Schema::create('rows', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('CemeteryID'); // Adding foreign key column
            $table->string('SectionCode');
            $table->unsignedInteger('RowID');
            $table->unsignedInteger('GraveNum');
            $table->tinyInteger('GraveStatus')->nullable();
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
        Schema::dropIfExists('rows');
    }
};
