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
        Schema::create('cards_jp_list', function (Blueprint $table) {
            $table->id();
            $table->char("card_id");
            $table->string("time");
            $table->string("pack_name");
            $table->string("card_number");
            $table->string("rare");
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
        Schema::dropIfExists('cards_jp_list');
    }
};
