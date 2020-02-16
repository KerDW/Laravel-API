<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeRegistrationPlatePrimaryKeyCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropUnique(['registration_plate']);
            $table->string('registration_plate')->primary()->change();
            $table->dropColumn('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cars', function (Blueprint $table) {
            $table->dropPrimary('registration_plate');
            $table->string('registration_plate')->unique()->change();
        });

        Schema::table('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
        });

    }
}
