<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDingDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ding_departments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('department_id')->comment('钉钉部门 id');
            $table->integer('department_pid')->comment('钉钉上级部门 id');
            $table->string('department_name')->comment('钉钉部门名称');
            $table->integer('auto_add_user')->default(0)->comment('是否同步创建一个关联此部门的企业群，1 表示是，0 表示不是');
            $table->integer('create_dept_group')->default(0)->comment('是否同步创建一个关联此部门的企业群，1 表示是，0 表示不是');
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
        Schema::dropIfExists('ding_departments');
    }
}
