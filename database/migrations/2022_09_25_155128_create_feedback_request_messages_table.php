<?php

use App\Domain\Contracts\FeedbackRequestMessageContract;
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
        Schema::create(FeedbackRequestMessageContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->unsignedBigInteger(MainContract::FEEDBACK_REQUEST_ID);
            $table->string(MainContract::TYPE);
            $table->text(MainContract::DESCRIPTION);
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
        Schema::dropIfExists(FeedbackRequestMessageContract::TABLE);
    }
};
