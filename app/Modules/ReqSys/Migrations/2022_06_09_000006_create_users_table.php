<?php

use Modules\ReqSys\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Staff;

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
            $table->string('login', 32)->unique();
            $table->string('password_hash', 255);
            $table->string('password_salt', 64);
            $table->foreignIdFor(Staff::class, 'gaz_staff_id')->unique()->references('id')->on(Config::get('database.connections.gaz.database') . '.staff')->cascadeOnUpdate()->cascadeOnDelete();
            $table->boolean('admin')->default(false);
            $table->softDeletes();
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
