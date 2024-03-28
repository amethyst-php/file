<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.file.data.file.table'), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('path')->nullable();
            $table->boolean('public')->default(false);
            $table->string('token');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(Config::get('amethyst.file.data.file.table'));
    }
}
