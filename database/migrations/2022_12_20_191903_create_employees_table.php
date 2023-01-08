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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->nullable()
                ->constrained();
            $table->string('first_name');
            $table->string('second_name');
            $table->string('patronymic');
            $table->date('birthday');
            $table->string('work_phone_number');
            $table->string('mobile_phone_number');
            $table->string('email');
            $table->string('position');
            $table->foreignId('photo_id')
                ->nullable()
                ->constrained();
            $table->foreignId('area_id')
                ->nullable()
                ->constrained();
            $table->enum('type', ['sup', 'em'])->default('em');
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
        Schema::dropIfExists('employees');
    }
};
