<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\PositionContract;
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
        Schema::create(PositionContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(MainContract::TITLE);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(1);
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
        Schema::dropIfExists(PositionContract::TABLE);
    }
};
