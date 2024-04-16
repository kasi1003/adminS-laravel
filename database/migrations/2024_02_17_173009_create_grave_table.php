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
            $table->string('RowID');
            $table->unsignedInteger('GraveNum');
            $table->decimal('Price', 10, 2)->nullable();

            $table->tinyInteger('GraveStatus')->nullable();
            $table->string('BuriedPersonsName')->nullable();
            $table->date('DateOfBirth')->nullable();
            $table->date('DateOfDeath')->nullable();
            $table->unsignedInteger('DeathCode')->nullable();

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
        Schema::dropIfExists('grave');
    }
};
