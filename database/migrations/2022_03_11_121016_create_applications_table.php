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
            $table->unsignedTinyInteger(MainContract::UPLOAD_STATUS_ID)->default(1);
            $table->unsignedInteger(MainContract::DOCUMENT_ALL)->default(0);
            $table->unsignedInteger(MainContract::DOCUMENT_AVAILABLE)->default(0);
            $table->text(MainContract::COMMENT)->nullable();
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
