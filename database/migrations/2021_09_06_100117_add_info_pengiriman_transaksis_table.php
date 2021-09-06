<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddInfoPengirimanTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->enum('jenis', ['dikirim', 'diambil'])->default('diambil');
            $table->string('pengiriman_via')->nullable();
            $table->text('alamat_pengiriman')->nullable();
            $table->integer('ongkir')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('jenis');
            $table->dropColumn('pengiriman_via');
            $table->dropColumn('alamat_pengiriman');
            $table->dropColumn('ongkir');
        });
    }
}
