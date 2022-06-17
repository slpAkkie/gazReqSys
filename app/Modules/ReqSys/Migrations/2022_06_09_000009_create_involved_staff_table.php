<?php

use Modules\ReqSys\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Staff;
use Modules\ReqSys\Models\Req;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('involved_staff', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Req::class)->references('id')->on('reqs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Staff::class, 'gaz_staff_id')->references('id')->on(Config::get('database.connections.gaz.database') . '.staff')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('involved_staff');
    }
};
