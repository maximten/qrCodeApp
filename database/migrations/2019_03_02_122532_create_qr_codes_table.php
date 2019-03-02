<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qr_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('hash')->unique();
            $table->unsignedBigInteger('type_id');
            $table->string('url');
            $table->boolean('status');
            $table->timestamps();

            $table->unique('url', 'type_id');
            $table->foreign('type_id')
            ->references('id')
            ->on('qr_codes_types')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qr_codes');
    }
}
