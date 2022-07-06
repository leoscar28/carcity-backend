<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserBannerContract;
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
        Schema::create('user_banners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->unsignedTinyInteger(MainContract::TYPE)->default(1);
            $table->json(MainContract::CATEGORY_ID);
            $table->json(MainContract::BRAND_ID);
            $table->string(MainContract::TITLE);
            $table->text(MainContract::DESCRIPTION);
            $table->unsignedSmallInteger(MainContract::ROOM_ID);
            $table->json(MainContract::WEEKDAYS);
            $table->json(MainContract::TIME);
            $table->string(MainContract::EMPLOYEE_NAME);
            $table->string(MainContract::EMPLOYEE_PHONE);
            $table->string(MainContract::EMPLOYEE_NAME_ADDITIONAL)->nullable();
            $table->string(MainContract::EMPLOYEE_PHONE_ADDITIONAL)->nullable();
            $table->text(MainContract::COMMENT)->nullable();
            $table->unsignedTinyInteger(MainContract::STATUS)->default(UserBannerContract::STATUS_CREATED);
            $table->unsignedTinyInteger(MainContract::IS_PUBLISHED)->default(UserBannerContract::IS_NOT_PUBLISHED);
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
        Schema::dropIfExists('user_banners');
    }
};
