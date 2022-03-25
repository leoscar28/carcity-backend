<?php

use App\Domain\Contracts\ApplicationContract;
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
        Schema::create(ApplicationContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::RID);
            $table->unsignedTinyInteger(MainContract::UPLOAD_STATUS_ID)
                ->default(1);
            $table->string(MainContract::CUSTOMER)->nullable();
            $table->bigInteger(MainContract::CUSTOMER_ID)->nullable();
            $table->string(MainContract::NUMBER)->nullable();
            $table->string(MainContract::ORGANIZATION)->nullable();
            $table->date(MainContract::DATE)->nullable();
            $table->string(MainContract::SUM)->nullable();
            $table->string(MainContract::NAME)->nullable();
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
        Schema::dropIfExists(ApplicationContract::TABLE);
    }
};
