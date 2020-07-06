<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('holder');
            $table->string('email');
            $table->string('bic');
            $table->string('iban');
            $table->string('bank');
            $table->string('bank_address');
            $table->string('phone', 25);
            $table->string('facebook');
            $table->string('home');
            $table->text('home_infos')->nullable();
            $table->text('home_shipping')->nullable();
            $table->boolean('invoice')->default(true);
            $table->boolean('card')->default(true);
            $table->boolean('transfer')->default(true);
            $table->boolean('check')->default(true);
            $table->boolean('mandat')->default(true);
            $table->boolean('paypal')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}
