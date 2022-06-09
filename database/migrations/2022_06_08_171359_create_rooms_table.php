<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RoomContract;
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
    public function up(): void
    {
        Schema::create(RoomContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger(MainContract::TIER_ID)->nullable();
            $table->unsignedInteger(MainContract::ROOM_TYPE_ID)->nullable();
            $table->unsignedBigInteger(MainContract::USER_ID)->nullable();
            $table->string(MainContract::TITLE)->nullable();
            $table->unsignedTinyInteger(MainContract::STATUS)->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(RoomContract::TABLE);
    }
};
