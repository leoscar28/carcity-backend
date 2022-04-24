<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\NotificationTenantContract;
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
        Schema::create(NotificationTenantContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->unsignedTinyInteger(MainContract::TYPE)->default(0);
            $table->unsignedBigInteger(MainContract::APPLICATION_ID)->nullable();
            $table->unsignedBigInteger(MainContract::COMPLETION_ID)->nullable();
            $table->unsignedBigInteger(MainContract::INVOICE_ID)->nullable();
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
        Schema::dropIfExists(NotificationTenantContract::TABLE);
    }
};
