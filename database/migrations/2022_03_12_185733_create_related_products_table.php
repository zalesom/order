<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('related_products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedDecimal('price', places: 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('related_products');
    }
};
