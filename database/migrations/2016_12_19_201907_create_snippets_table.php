<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSnippetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('snippets', function (Blueprint $table) {
            $table->softDeletes();
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id') 
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
            $table->text('text');
            $table->string('syntax')->default('txt');
            $table->boolean('public')->default(false);
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
        Schema::dropIfExists('snippets');
    }
}
