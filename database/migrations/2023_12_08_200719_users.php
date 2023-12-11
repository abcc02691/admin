<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration
{
    

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('users',function(Blueprint $table){
            $table->increments('id')->comment('使用者流水號');

            $table->string('name',50)->comment('使用者名稱');

            $table->date('birthday')->comment('使用者生日');

            $table->string('email',100)->comment('使用者信箱');

            $table->string('account',25)->comment('使用者帳號');

            $table->string('password',25)->comment('使用者密碼');
            
            $table->integer('status')->default(0)->comment('審核狀態 0:審核中 1:審核通過');
            
            $table->unsignedInteger('org_id')->comment('組織編號');
            
            //時間戳記
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::table('users', function($table) {
            $table->foreign('org_id')->references('id')->on('orgs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
