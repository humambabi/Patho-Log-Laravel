<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
   /**
    * Run the migrations.
    *
    * @return void
    */
   public function up()
   {
      Schema::create('users', function (Blueprint $table) {
         $table->charset = 'utf8mb4';
         $table->collation = 'utf8mb4_general_ci';

         $table->increments('id'); // UNSIGNED INTEGER AUTO-INCREMENT
         $table->tinyText('name')->nullable(false);
         $table->tinyText('email')->nullable(false);
         $table->tinyText('pw_hash')->nullable(false);
         $table->dateTime('reg_datetime')->nullable(false);
         $table->tinyText('verification_code')->nullable(false);
         $table->dateTime('vercode_datetime')->nullable(true)->default(null);
         $table->boolean('is_emailverified')->nullable(false)->default(0);
         $table->dateTime('resetpw_datetime')->nullable(true)->default(null);
         $table->tinyText('resetpw_code')->nullable(true)->default(null);
         $table->text('ipaddrs_obj')->nullable(false);
         $table->boolean('is_admin')->nullable(false)->default(0);
      });
   }

   /**
    * Reverse the migrations.
    *
    * @return void
    */
   public function down()
   {
      Schema::dropIfExists('users');
   }
}
