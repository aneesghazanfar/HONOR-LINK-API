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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('no');
            $table->string('userid', 50)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('password', 255)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->string('username', 20)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->decimal('balance', 18, 2);
            $table->string('remote_ip', 20)->charset('utf8mb4')->collation('utf8mb4_general_ci');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
