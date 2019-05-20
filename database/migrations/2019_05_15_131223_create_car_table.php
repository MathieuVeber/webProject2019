<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car', function (Blueprint $table) {
            $table->string('license_plate')->primary();
            $table->unsignedInteger('owner')->references('id')->on('user')->onDelete('cascade');
            $table->string('make');
            $table->string('model');
            $table->year('year');
            $table->boolean('forSale')->default(false);
            $table->year('firstRegistration');
            $table->enum('problem_type',['mechanical','bodyCar','both'])->nullable();
            $table->enum('problem_request',['estimate','appointment','both'])->nullable();
            $table->string('problem_description')->nullable();
            $table->string('problem_picture')->nullable();
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
        Schema::dropIfExists('car');
    }
}
