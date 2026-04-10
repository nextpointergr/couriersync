<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        // Πίνακας Παρόχων
        Schema::create('courier_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('file_type')->default('csv'); // csv, xlsx, xls
            $table->string('delimiter')->default(';');
            $table->string('map_class'); // π.χ. App\CourierMaps\AcsMap
            $table->timestamps();
        });
    }
};