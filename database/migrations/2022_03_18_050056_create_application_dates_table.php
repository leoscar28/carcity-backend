<?php

use App\Domain\Contracts\ApplicationDateContract;
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
        Schema::create(ApplicationDateContract::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(MainContract::UPLOAD_STATUS_ID);
            $table->unsignedBigInteger(MainContract::RID);
            $table->unsignedInteger(MainContract::DOCUMENT_ALL)->default(0);
            $table->unsignedInteger(MainContract::DOCUMENT_AVAILABLE)->default(0);
            $table->text(MainContract::COMMENT)->nullable();
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
        Schema::dropIfExists(ApplicationDateContract::TABLE);
    }
};
