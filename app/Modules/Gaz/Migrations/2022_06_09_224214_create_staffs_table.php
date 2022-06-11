<?php

use Modules\Gaz\Migrations\Migration;
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
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('last_name', 16);
            $table->string('first_name', 16);
            $table->string('second_name', 16);
            $table->string('emp_number', 6);
            $table->string('email', 64)->unique();
            $table->string('insurance_number', 14)->unique();
            $table->boolean('deactivated')->default(false);
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
        Schema::dropIfExists('staff');
    }
};
