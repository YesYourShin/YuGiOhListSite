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
        Schema::create('ko_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon')->nullable();
            $table->string('attribute')->nullable();
            $table->string('level')->nullable();
            $table->string('rank')->nullable();
            $table->string('link')->nullable();
            $table->string('link_arrow')->nullable();
            $table->string('p_scale')->nullable();
            $table->text('p_effect')->nullable();
            $table->text('card_text')->nullable();
            $table->text('monster_type')->nullable();
            $table->text('card_type')->nullable();
            $table->string('atk')->nullable();
            $table->string('def')->nullable();
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
        Schema::dropIfExists('cards_kr');
    }
};
