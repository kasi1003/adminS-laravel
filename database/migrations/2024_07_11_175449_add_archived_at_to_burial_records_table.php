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
    Schema::table('burial_records', function (Blueprint $table) {
        $table->timestamp('archived_at')->nullable();
    });
}

public function down()
{
    Schema::table('burial_records', function (Blueprint $table) {
        $table->dropColumn('archived_at');
    });
}

};
