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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_no');
            $table->string('nama_penuh');
            $table->string('no_ic');
            $table->unsignedBigInteger('jabatan_id');
            $table->string('jawatan')->nullable();
            $table->string('no_tel_bimbit')->nullable();
            $table->string('no_tel_pejabat')->nullable();
            $table->string('email');
            $table->string('kegunaan')->nullable();
            $table->text('catatan')->nullable();
            $table->date('tarikh_mula');       
            $table->time('masa_mula');         
            $table->date('tarikh_tamat');      
            $table->time('masa_tamat');        
            $table->unsignedBigInteger('location_id');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
