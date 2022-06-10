<?php

use Modules\GReqSys\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Stuff;
use Modules\GReqSys\Models\Req;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('involved_stuff', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Req::class)->references('id')->on('reqs')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Stuff::class, 'gaz_stuff_id')->references('id')->on(Config::get('database.connections.gaz.database') . '.stuff')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('involved_stuff');
    }
};
