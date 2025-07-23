<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrintersTable extends Migration
{
    public function up()
    {
        Schema::create('printers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('ip_address')->unique();
            $table->foreignId('printer_type_id')->constrained()->cascadeOnDelete();
            $table->string('serial_number')->nullable()->index();
            $table->string('location')->nullable();
            $table->string('phone_extension')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('printers');
    }
}
