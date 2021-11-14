<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSpendLimitsTable extends Migration
{
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spend_limits', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->integer('price')->default(0);
            $table->integer('requests')->default(0);
            $table->integer('contacts')->default(0);
            $table->integer('throttle')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spend_limits');
    }
}
