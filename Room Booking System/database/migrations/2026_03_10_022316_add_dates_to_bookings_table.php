<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->date('tarikh_mula')->after('catatan');
            $table->time('masa_mula')->after('tarikh_mula');
            $table->date('tarikh_tamat')->after('masa_mula');
            $table->time('masa_tamat')->after('tarikh_tamat');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            //
        });
    }
};
