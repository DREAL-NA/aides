<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class AddPublishedAtColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calls_for_projects', function (Blueprint $table) {
            $table->dateTime('published_at')->nullable();
        });

        $cfps = DB::table('calls_for_projects')->select('id','updated_at')->get();
        foreach ($cfps as $cfp)
        {
            DB::table('calls_for_projects')
                ->where('id', $cfp->id)
                ->update([
                    'published_at' => $cfp->updated_at
                ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calls_for_projects', function (Blueprint $table) {
            $table->dropColumn('published_at');
        });
    }
}
