<?php

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
        //
        Schema::table('conversions', function (Blueprint $table) {
            $table->float('amount_to_convert', 12, 4)->change();
            $table->float('converted_amount', 12, 4)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('conversions', function (Blueprint $table) {
            $table->float('amount_to_convert', 8, 2)->change();
            $table->float('converted_amount', 8, 2)->change();
        });
    }
};
