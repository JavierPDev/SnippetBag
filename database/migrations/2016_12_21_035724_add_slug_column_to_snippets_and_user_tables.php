<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSlugColumnToSnippetsAndUserTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snippets', function (Blueprint $table) {
          $table->string('slug');
        });

        Schema::table('users', function (Blueprint $table) {
          $table->string('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snippets', function (Blueprint $table) {
          $table->dropColumn('slug');
        });

        Schema::table('users', function (Blueprint $table) {
          $table->dropColumn('slug');
        });
    }
}
