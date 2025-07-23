<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTonersTable extends Migration
{
    public function up()
    {
        Schema::create('toners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('color')->nullable();
            $table->integer('stock_count')->default(0);
            $table->string('barcode')->nullable()->unique();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('toners');
    }
}
