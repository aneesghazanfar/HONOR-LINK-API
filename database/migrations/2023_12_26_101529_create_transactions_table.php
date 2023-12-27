<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('no');
            $table->integer('userno');
            $table->string('userid', 50)->charset('utf8mb4');
            $table->bigInteger('tid');
            $table->string('type', 30)->charset('utf8mb4');
            $table->decimal('amount', 18, 2);
            $table->decimal('before', 18, 2);
            $table->string('status', 10)->charset('utf8mb4');
            $table->string('gameid', 100);
            $table->string('gametype', 20)->charset('utf8mb4');
            $table->string('gameround', 100);
            $table->string('gametitle', 50)->charset('utf8mb4');
            $table->string('gamevendor', 30)->charset('utf8mb4');
            $table->text('detail');
            $table->tinyInteger('detailUpdate');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');
            $table->dateTime('processed_at');

            $table->primary('no');
            $table->unique('tid');
            $table->index('gameround');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
