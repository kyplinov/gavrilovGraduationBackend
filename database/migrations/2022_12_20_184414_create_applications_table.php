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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date_completed')->nullable();
            $table->foreignId('employee_id')
                ->nullable()
                ->constrained();
            $table->bigInteger('support_id')->unsigned();
            $table->foreign('support_id')->references('id')->on('employees');
            $table->text('description')->nullable();
            $table->text('decide')->nullable();
            $table->bigInteger('status_id')->unsigned();
            $table->foreign('status_id')->references('id')->on('statuses');
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
        Schema::dropIfExists('applications');
    }
};
