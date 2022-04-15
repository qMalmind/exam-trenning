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
        Schema::table("users", function(Blueprint $table){
            $table->unsignedBigInteger("role_id")->nullable();
            $table->foreign("role_id")->references("id")->on("roles")
                ->onUpdate("cascade")
                ->onDelete("cascade");
            $table->string("login");
            $table->string("city")->nullable();
            $table->string("phone")->nullable();
            $table->date("date_birth")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['role_id']);
            $table->dropColumn('role_id');
        });
        Schema::dropColumns("users", "login");
        Schema::dropColumns("users", "city");
        Schema::dropColumns("users", "phone");
        Schema::dropColumns("users", "date_birth");
    }
};
