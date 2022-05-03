<?php

use App\Domain\Contracts\CompletionSignatureContract;
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
        Schema::create(CompletionSignatureContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::COMPLETION_ID);
            $table->unsignedBigInteger(MainContract::USER_ID);
            $table->text(MainContract::SIGNATURE);
            $table->text(MainContract::DATA);
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
        Schema::dropIfExists(CompletionSignatureContract::TABLE);
    }
};
