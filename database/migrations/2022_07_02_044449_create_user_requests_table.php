<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\UserRequestContract;
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
        Schema::create('user_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->string(MainContract::PHONE);
            $table->unsignedBigInteger(MainContract::CATEGORY_ID);
            $table->unsignedBigInteger(MainContract::BRAND_ID);
            $table->text(MainContract::DESCRIPTION);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(UserRequestContract::STATUS_ACTIVE);
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
        Schema::dropIfExists('user_requests');
    }
};
