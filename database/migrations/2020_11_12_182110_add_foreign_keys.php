<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flight', function (Blueprint $table) {
            $table->foreign("departure_id", "departure")->references("id")->on("airport")->onDelete("cascade");
            $table->foreign("arrival_id", "arrival")->references("id")->on("airport")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('flight', function (Blueprint $table) {
            $table->dropForeign("departure");
            $table->dropForeign("arrival");
        });
    }
}
