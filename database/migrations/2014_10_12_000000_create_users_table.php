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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string("Firstname");
            $table->string("Middlename");
            $table->string("Lastname");
            $table->string("Sex");
            $table->integer("Role"); // 0 :admin / 1 : Instructor / 2 :Client
            $table->integer('SectionID');
            $table->integer('BatchID');
            $table->string('StudentID')->unique()->nullable();
            $table->integer('printcount');
            $table->integer('vrfy');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
