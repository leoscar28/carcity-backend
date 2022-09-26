<?php

use App\Domain\Contracts\FeedbackRequestContract;
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
        Schema::create(FeedbackRequestContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->string(MainContract::TITLE);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(FeedbackRequestContract::STATUS_NEW);
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
        Schema::dropIfExists(FeedbackRequestContract::TABLE);
    }
};
