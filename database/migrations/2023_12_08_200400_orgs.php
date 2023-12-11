<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orgs extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //id,title,org_no,created_at,updated_at
        Schema::create('orgs',function(Blueprint $table){
            //id 流水號
            $table->increments('id');
            
            //title
            $table->string('title',30)->comment('組織名稱');
            
            //org_no
            $table->string('org_no',10)->comment('組織編號');
            
            //時間戳記
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
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
