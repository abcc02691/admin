<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ApplyFile extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //{ id, user_id, file_path created_at,updated_at}
        Schema::create('apply_file',function(Blueprint $table){
            
            $table->increments('id')->comment('檔案編號');
            
            $table->unsignedInteger('user_id')->comment('使用者編號');
            
            $table->string('file_path',100)->comment('檔案路徑');
            
            //時間戳記
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::table('apply_file', function($table) {
            $table->foreign('user_id')->references('id')->on('users');
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
