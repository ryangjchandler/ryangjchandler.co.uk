<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewsTable extends Migration
{
    public function up()
    {
        Schema::connection('analytics')->create('views', function (Blueprint $table) {
            $table->id();
            $table->morphs('viewable');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('analytics')->dropIfExists('views');
    }
}
