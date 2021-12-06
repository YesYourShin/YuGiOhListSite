<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOricasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oricas', function (Blueprint $table) {
            $table->id();

            $table->text("title");
            $table->text("effect");
            $table->text("pEffect")->nullable();
            $table->string("icon")->nullable();
            $table->string("attribute")->nullable();
            $table->string("level")->nullable();
            $table->string("rank")->nullable();
            $table->string("pScale")->nullable();
            $table->string("link")->nullable();
            $table->string("linkArray")->nullable();
            $table->string("monsterType")->nullable();
            $table->string("category")->nullable();
            $table->string("monsterCategory")->nullable();
            $table->string("atk")->nullable();
            $table->string("def")->nullable();
            
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
        Schema::dropIfExists('oricas');
    }
}
