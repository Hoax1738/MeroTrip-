<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImeInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ime_info', function (Blueprint $table) {
            $table->id();
            $table->string('MerchantCode',10)->nullable();
            $table->integer('TranAmount')->nullable();
            $table->string('RefId',20)->nullable();
            $table->string('TokenId',20)->nullable();
            $table->string('TransactionId',20)->nullable();
            $table->string('Msisdn',20)->nullable();
            $table->integer('ImeTxnStatus')->nullable();
            $table->timestamp('RequestDate')->nullable();
            $table->timestamp('RespnseDate')->nullable();
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
        Schema::dropIfExists('ime_info');
    }
}
