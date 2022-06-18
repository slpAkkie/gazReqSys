<?php

use Modules\WT\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
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
            $table->id();
            $table->string('first_name', 16);
            $table->string('last_name', 16);
            $table->string('second_name', 16);
            $table->string('login', 64)->unique();
            $table->string('password_hash', 255);
            $table->string('password_salt', 255);
            $table->string('email', 64)->unique();
            $table->string('insurance_number', 14);
            $table->foreign('insurance_number')->unique()->references('insurance_number')->on(Config::get('database.connections.gaz.database') . '.staff')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('disabled')->default(false);
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
