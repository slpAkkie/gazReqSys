<?php

use Modules\Gaz\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Organization;
use Modules\Gaz\Models\Post;
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
        Schema::create('staff_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Staff::class)->references('id')->on('staff')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('hired_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignIdFor(Post::class)->references('id')->on('posts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Organization::class)->references('id')->on('organizations')->cascadeOnUpdate()->cascadeOnDelete();
            $table->softDeletes('fired_at');
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
        Schema::dropIfExists('staff_history');
    }
};
