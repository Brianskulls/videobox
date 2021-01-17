<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdFieldToTasks extends Migration
{
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->foreignId('user_id')->references('id')->on('users')->cascadeOnDelete();
        });
    }

    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
