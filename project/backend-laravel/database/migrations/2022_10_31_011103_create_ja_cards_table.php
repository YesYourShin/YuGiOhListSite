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
        Schema::create('ja_cards', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("name2");
            $table->char("icon")->nullable();
            $table->char("attribute")->nullable();
            $table->char("level")->nullable();
            $table->char("rank")->nullable();
            $table->char("link")->nullable();
            $table->char("link_arrow")->nullable();
            $table->char("p_scale")->nullable();
            $table->text("p_effect")->nullable();
            $table->text("card_text")->nullable();
            $table->text("monster_type")->nullable();
            $table->text("card_type")->nullable();
            $table->char("atk")->nullable();
            $table->char("def")->nullable();
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
        Schema::dropIfExists('cards_jp');
    }
};
