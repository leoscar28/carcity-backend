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
        Schema::create('feedback_request_message_images', function (Blueprint $table) {
            $table->increments(MainContract::ID);
            $table->unsignedBigInteger(MainContract::FEEDBACK_REQUEST_MESSAGE_ID);
            $table->string(MainContract::TITLE);
            $table->string(MainContract::PATH);
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
        Schema::dropIfExists('feedback_request_message_images');
    }
};
