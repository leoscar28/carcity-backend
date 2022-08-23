<?php

use App\Domain\Contracts\MainContract;
use App\Domain\Contracts\RuleContract;
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
        Schema::create(RuleContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->mediumText(MainContract::BODY)->nullable();
            $table->mediumText(MainContract::BODY_KZ)->nullable();
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
        Schema::dropIfExists(RuleContract::TABLE);
    }
};
