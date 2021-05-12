<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtraccionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extraccions', function (Blueprint $table) {
            $table->id();
            $table->integer('compania_id')->unsigned();
            $table->integer('tipodoc_id')->unisgned();
            $table->string('nombre',100)->index();
            $table->json('documento')->nullable();
            $table->string('estado',3)->default('ACT');
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
        Schema::dropIfExists('extraccions');
    }
}
