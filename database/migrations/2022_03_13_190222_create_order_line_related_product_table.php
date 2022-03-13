<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_line_related_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_line_id')->constrained()->cascadeOnDelete();
            $table->foreignId('related_product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title')->nullable();
            $table->unsignedDecimal('price', places: 2)->default(0);
            $table->unsignedSmallInteger('quantity')->default(1);
            $table->unsignedDecimal('total', places: 2)->storedAs('price * quantity')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_line_related_product');
    }
};
