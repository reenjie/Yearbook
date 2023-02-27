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
        Schema::create('frontpages', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('file')->nullable();
            $table->text('message')->nullable();
            $table->text('otherinfo')->nullable();
            $table->integer('arrangement');
            $table->integer('pagetype')->comment('0 = front , 1 = back');
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
        Schema::dropIfExists('frontpages');
    }
};
