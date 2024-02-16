<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable7Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_7', function (Blueprint $table) {
            $table->id();
            $table->string('campo_1')->nullable();
            $table->string('campo_2')->nullable();
            $table->string('campo_3')->nullable();
            $table->foreignId('table_4_id')->nullable()->references('id')->on('table_3_4');
            // $table->integer('campo_4')->nullable();
            $table->integer('campo_4')->default('0');
            $table->char('state')->default('A');
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
        Schema::dropIfExists('table_7');
    }
}
