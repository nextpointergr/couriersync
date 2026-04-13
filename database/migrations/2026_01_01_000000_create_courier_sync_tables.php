<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Πίνακας Παρόχων
        Schema::create('courier_providers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Όνομα μεταφορικής (π.χ. ACS)');
            $table->string('slug')->unique()->comment('Slug για κλήση από κώδικα');
            $table->string('file_type')->default('csv')->comment('csv, xlsx, xls');
            $table->string('delimiter')->default(';')->comment('Διαχωριστής για CSV');
            $table->string('map_class')->nullable()->comment('Namespace του αυτόματου Mapper');
            $table->timestamps();
        });

        // Πίνακας Ιστορικού Ανεβάσματος
        Schema::create('courier_uploads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_provider_id')->constrained('courier_providers')->onDelete('cascade');
            $table->string('filename')->comment('Το όνομα του αρχείου');
            $table->integer('total_rows')->default(0)->comment('Σύνολο γραμμών που αναγνωρίστηκαν');
            $table->string('status')->default('pending')->comment('pending, success, failed');
            $table->text('error_message')->nullable()->comment('Σφάλμα αν αποτύχει η διαδικασία');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('courier_uploads');
        Schema::dropIfExists('courier_providers');
    }
};
