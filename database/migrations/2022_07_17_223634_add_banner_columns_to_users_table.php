<?php

use App\Domain\Contracts\MainContract;
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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger(MainContract::SPARE_PART_ID)->nullable();
            $table->unsignedBigInteger(MainContract::BRAND_ID)->nullable();
            $table->unsignedBigInteger(MainContract::SERVICE_ID)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(MainContract::SERVICE_ID);
            $table->dropColumn(MainContract::BRAND_ID);
            $table->dropColumn(MainContract::SPARE_PART_ID);
        });
    }
};
