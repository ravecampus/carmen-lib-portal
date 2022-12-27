<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLibProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lib_profile', function (Blueprint $table) {
            $table->id();
            $table->string("image")->nullable();
            $table->string("title")->nullable();
            $table->text("description")->nullable();
            $table->text("history")->nullable();
            $table->text("mission")->nullable();
            $table->text("vision")->nullable();
            $table->text("rules_regulation")->nullable();
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
        Schema::dropIfExists('lib_profile');
    }
}
