<?php

use App\Enums\CustomerTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('phone')->unique();
            $table->string('address');
            $table->string('province_code');
            $table->string('province_name');
            $table->string('city_code');
            $table->string('city_name');
            $table->string('subdistrict_code');
            $table->string('subdistrict_name');
            $table->string('village_code');
            $table->string('village_name');
            $table->string('postal_code');
            $table->string('type')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
