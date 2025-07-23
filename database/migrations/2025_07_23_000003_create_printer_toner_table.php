<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrinterTonerTable extends Migration
{
    public function up()
    {
        Schema::create('printer_toner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('printer_id')->constrained()->cascadeOnDelete();
            $table->foreignId('toner_id')->constrained()->cascadeOnDelete();
            $table->dateTime('installed_at')->nullable();
            $table->integer('usage_pages')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('printer_toner');
    }
}
