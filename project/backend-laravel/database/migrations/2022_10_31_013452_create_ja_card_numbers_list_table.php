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
        Schema::create('ja_card_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('card_id');
            $table->string('time');
            $table->string('card_number')->nullable();
            $table->string('pack_name');
            $table->string('rare');
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
