<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calls', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('priority')->index();
            $table->string('phone_number');
            $table->integer('support_id')->nullable();
            $table->tinyInteger('status')->index();
            $table->timestamps();

            $table->foreign('support_id')
                ->references('supports')
                ->on('id')
                ->onDelete('restrict')
                ->onUpdate('cascade')
                ->name('support_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calls');
    }
}
