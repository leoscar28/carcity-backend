<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\NotificationContract;
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
        Schema::create(NotificationContract::TABLE, function (Blueprint $table) {
            $table->id()->unsigned();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->unsignedBigInteger(MainContract::FOREIGN_ID);
            $table->unsignedTinyInteger(MainContract::TYPE)->default(0);
            $table->unsignedTinyInteger(MainContract::VIEW)->default(0);
            $table->unsignedTinyInteger(MainContract::STATUS)->default(1);
            $table->timestamps();
            $table->index(MainContract::USER_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(NotificationContract::TABLE);
    }
};
