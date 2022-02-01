<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilePermissionUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_user_permission', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->text('path');
            $table->string('disk');
            $table->text('access');
            $table->string('type');
            $table->boolean('has_all')->default(false);
            $table->text('parent')->nullable();

            //$table->unique(['user_id','path','type']);
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
        Schema::dropIfExists('file_user_permission');
    }
}
