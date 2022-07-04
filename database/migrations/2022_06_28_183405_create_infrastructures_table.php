<?php

use App\Domain\Contracts\InfrastructureContract;
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
    public function up(): void
    {
        Schema::create(InfrastructureContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->string(MainContract::TITLE)->nullable();
            $table->string(MainContract::TITLE_KZ)->nullable();
            $table->text(MainContract::DESCRIPTION)->nullable();
            $table->text(MainContract::DESCRIPTION_KZ)->nullable();
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
        Schema::dropIfExists(InfrastructureContract::TABLE);
    }
};
