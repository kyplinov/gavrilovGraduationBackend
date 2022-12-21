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
        Schema::create('configuration_units', function (Blueprint $table) {
            $table->id();
            $table->string('number');
            $table->string('serial_number');
            $table->string('name');
            $table->foreignId('configuration_unit_type_id')
                ->constrained();
            $table->foreignId('area_id')
                ->constrained();
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('configuration_units');
    }
};
