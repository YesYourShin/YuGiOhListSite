<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("title2");
            $table->string("limited")->nullable();
            $table->string("icon")->nullable();
            $table->string("attribute")->nullable();
            $table->string("level")->nullable();
            $table->string("rank")->nullable();
            $table->string("link")->nullable();
            $table->string("atk")->nullable();
            $table->string("def")->nullable();
            $table->string("monsterType")->nullable();
            $table->string("cardType")->nullable();
            $table->string("pScale")->nullable();
            $table->text("pEffect")->nullable();
            $table->text("cardText");

            // $table->string("card_id")->nullable()->unique();
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
        Schema::dropIfExists('cards');
    }
}
