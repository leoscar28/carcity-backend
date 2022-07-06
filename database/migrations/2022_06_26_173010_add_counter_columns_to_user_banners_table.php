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
        Schema::table('user_banners', function (Blueprint $table) {
            $table->integer('view_count');
            $table->integer('phone_view_count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_banners', function (Blueprint $table) {
            $table->dropColumn('phone_view_count');
            $table->dropColumn('view_count');
        });
    }
};
