<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->string('key')->unique()->nullable();

            //Where You Can See The Menu
            $table->string('location')->nullable();

            //Title For The Menu
            $table->string('title')->nullable();

            //Menu Item As Json
            $table->longText('items')->nullable();

            //Are Menu Is Active?
            $table->boolean('activated')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn('key');

            //Where You Can See The Menu
            $table->dropColumn('location');

            //Title For The Menu
            $table->dropColumn('title');

            //Menu Item As Json
            $table->dropColumn('items');

            //Are Menu Is Active?
            $table->dropColumn('activated');
        });
    }
};
