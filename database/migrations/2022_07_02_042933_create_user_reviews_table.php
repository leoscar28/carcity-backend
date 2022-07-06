<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserReviewContract;
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
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->unsignedBigInteger(MainContract::CUSTOMER_ID);
            $table->unsignedBigInteger(MainContract::USER_BANNER_ID);
            $table->integer(MainContract::RATING);
            $table->text(MainContract::DESCRIPTION);
            $table->text(MainContract::COMMENT);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(UserReviewContract::STATUS_ACTIVE);
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
        Schema::dropIfExists('user_reviews');
    }
};
