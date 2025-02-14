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
        Schema::create('clusters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instance_id');
            $table->foreignId('subinstance_id');
            $table->string('kode');
            $table->string('name');
            $table->float('xpercentage_water')->nullable();
            $table->float('yfixed_cost_water')->nullable();
            $table->float('xpercentage_power')->nullable();
            $table->float('yfixed_cost_power')->nullable();
            $table->float('xpercentage_gas')->nullable();
            $table->float('yfixed_cost_gas')->nullable();
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
        Schema::dropIfExists('clusters');
    }
};
