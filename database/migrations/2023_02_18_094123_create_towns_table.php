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
        Schema::create('towns', function (Blueprint $table) {
            $table->increments('town_id'); // Adding auto-increment primary key
            $table->unsignedInteger('region_id'); // Adding foreign key column
            $table->string('name'); // Adding varchar column for name
            $table->timestamps();

            // Adding foreign key constraint
            $table->foreign('region_id')->references('region_id')->on('regions')->onDelete('cascade');
            $table->index('region_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('towns');
    }
};
