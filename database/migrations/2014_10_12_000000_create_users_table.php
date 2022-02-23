<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserContract;
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
        Schema::create(UserContract::TABLE, function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedTinyInteger(MainContract::TYPE)->default(1);
            $table->string(MainContract::TOKEN);
            $table->string(MainContract::NAME);
            $table->string(MainContract::SURNAME);
            $table->string(MainContract::LAST_NAME)->nullable();
            $table->date(MainContract::BIRTHDATE)->nullable();
            $table->unsignedTinyInteger(MainContract::HIDE_BIRTHDATE)->default(0);
            $table->unsignedBigInteger(MainContract::ROLE_ID)->nullable();
            $table->string(MainContract::COMPANY)->nullable();
            $table->string(MainContract::BIN,12)->nullable();
            $table->string(MainContract::EMAIL)->unique()->nullable();
            $table->char(MainContract::EMAIL_CODE,4)->nullable();
            $table->timestamp(MainContract::EMAIL_VERIFIED_AT)->nullable();
            $table->string(MainContract::PHONE)->unique()->nullable();
            $table->char(MainContract::PHONE_CODE,4)->nullable();
            $table->timestamp(MainContract::PHONE_VERIFIED_AT)->nullable();
            $table->string(MainContract::PASSWORD);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists(UserContract::TABLE);
    }
};
