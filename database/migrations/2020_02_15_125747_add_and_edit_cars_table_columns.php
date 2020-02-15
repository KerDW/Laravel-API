<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAndEditCarsTableColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cars', function (Blueprint $table) {
            
            $table->dropColumn("cars");
            $table->string("model");
            $table->string("registration_plate")->unique();
            $table->unsignedInteger("seat_number")->default(5);

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
            $table->dropColumn("seat_number");
            $table->dropColumn("registration_plate");
            $table->dropColumn("model");
            $table->string("cars");
        });
    }
}
