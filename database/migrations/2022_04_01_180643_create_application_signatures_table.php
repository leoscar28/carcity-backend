<?php

use App\Domain\Contracts\ApplicationSignatureContract;
use App\Domain\Contracts\MainContract;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create(ApplicationSignatureContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::APPLICATION_ID);
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->text(MainContract::SIGNATURE);
            $table->text(MainContract::DATA);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists(ApplicationSignatureContract::TABLE);
    }
};
