<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTable1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_1', function (Blueprint $table) {
            $table->id();
            $table->string('campo_1')->nullable();
            $table->string('campo_2')->nullable();
            $table->string('campo_3')->nullable();
            // $table->foreignId('table_2_id')->nullable()->references('id')->on('table_2');
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
        Schema::dropIfExists('table_1');
    }
}
