<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('printer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('oid')->nullable(); // <-- přidáno
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('printer_types');
    }
};

?>