<?php

use Modules\Gaz\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Gaz\Models\Department;
use Modules\Gaz\Models\Post;
use Modules\Gaz\Models\Stuff;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stuff_history', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Stuff::class)->references('id')->on('stuff')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('hired_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignIdFor(Post::class)->references('id')->on('posts')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignIdFor(Department::class)->references('id')->on('departments')->cascadeOnUpdate()->cascadeOnDelete();
            $table->timestamp('fired_at')->nullable();
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
        Schema::dropIfExists('stuff_history');
    }
};
