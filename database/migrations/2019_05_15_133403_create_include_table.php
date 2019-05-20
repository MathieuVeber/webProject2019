<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncludeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('include', function (Blueprint $table) {
            $table->unsignedInteger('idInvoice')->references('idInvoice')->on('invoice')->onDelete('cascade');
            $table->unsignedInteger('idrepair')->references('idrepair')->on('repair')->onDelete('cascade');
            $table->float('laborCost')->default(0);
            $table->float('technicalCost')->default(0);
            $table->primary(['idInvoice', 'idrepair']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('include');
    }
}
