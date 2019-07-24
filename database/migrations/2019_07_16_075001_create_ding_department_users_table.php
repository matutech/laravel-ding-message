<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDingDepartmentUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ding_department_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->comment('钉钉部门 id');
            $table->string('userid')->comment('钉钉用户 id');
            $table->string('name')->comment('用户名称');
            $table->timestamps();
            $table->index('department_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ding_department_users');
    }
}
