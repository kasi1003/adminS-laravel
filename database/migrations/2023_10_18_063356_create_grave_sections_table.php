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
            $table->unsignedInteger('CemeteryID'); // Adding foreign key column
            $table->string('SectionCode'); // Adding varchar column for section code
            $table->unsignedInteger('Rows'); // Adding int column for total graves
            $table->decimal('Price', 10, 2)->nullable();

            $table->string('SectionType')->nullable(); // Adding varchar column for section code
            $table->binary('SectionSvg')->nullable(); // Adding blob column for SVG map, allowing NULL values

            
            $table->timestamps(); // Adding created_at and updated_at columns

            // Adding foreign key constraint
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
        
        Schema::dropIfExists('grave_sections');
    }
};
