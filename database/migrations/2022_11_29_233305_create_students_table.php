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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string("studentid");
            $table->string("Firstname");
            $table->string("Middlename");
            $table->string("Lastname");
            $table->string("Sex");
            $table->date("Birthdate");
            $table->text("Address");
            $table->text("Honors")->nullable();
            $table->integer('SectionID');
            $table->integer('BatchID');
            $table->text('photo');
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
        Schema::dropIfExists('students');
    }
};
