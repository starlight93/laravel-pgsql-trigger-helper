<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Helpers\Plsql\Plsql as trigger;

class TriggerTb extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $db = trigger::table("tb_user")
                ->before('insert')
                ->declare([['variable1'=>'integer'],['variable2'=>'integer']])
                ->begin("new.nama='baru'")
                ->whenOr("new.nama <> '4'")
                ->when("new.nama <> '2'")
                ->create();
        DB::unprepared($db);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $trigger = trigger::table("tb_user")
                ->before('insert')
                ->drop();
        DB::unprepared($trigger);
    }
}
