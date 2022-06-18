<?php

use Modules\ReqSys\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Organization;
use Modules\ReqSys\Models\ReqStatus;
use Modules\ReqSys\Models\ReqType;
use Modules\ReqSys\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reqs', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ReqType::class, 'type_id')->references('id')->on('req_types')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('status_slug', 16)->default('waiting');
            $table->foreign('status_slug')->references('slug')->on('req_statuses')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(User::class, 'author_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Organization::class, 'gaz_organization_id')->references('id')->on(Config::get('database.connections.gaz.database') . '.organizations')->cascadeOnUpdate()->cascadeOnDelete();
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
        Schema::dropIfExists('reqs');
    }
};
