<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;

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
            $table->dropColumn('parent_id'); 
        });

        Schema::table('menus', function (Blueprint $table) {
            $table->bigInteger('parent_id')->nullable()->default(0)->after('icon');
        });
    }

    public function down()
    {
        // Вернуться к предыдущему состоянию
        Schema::table('menus', function (Blueprint $table) {
            // $table->dropColumn('parent_id');
        });
    }
};
