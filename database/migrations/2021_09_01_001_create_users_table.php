<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;


class CreateUsersTable extends Migration
{
   #
   # Run the migrations.
   #
   # @return void
   #
   public function up()
   {
      Schema::create('users', function (Blueprint $table) {
         $table->charset = 'utf8mb4';
         $table->collation = 'utf8mb4_general_ci';

         $table->increments('id'); # UNSIGNED INTEGER AUTO-INCREMENT
         $table->tinyText('name')->nullable(false);
         $table->tinyText('email')->nullable(false);
         $table->string('password');
         $table->dateTime('reg_datetime')->nullable(false);
         $table->tinyText('verification_code')->nullable(false);
         $table->dateTime('vercode_datetime')->nullable(true)->default(null);
         $table->boolean('is_emailverified')->nullable(false)->default(0);
         $table->tinyText('resetpw_code')->nullable(true)->default(null);
         $table->dateTime('rpwcode_datetime')->nullable(true)->default(null);
         $table->text('ipaddrs_obj')->nullable(false);
         $table->rememberToken();
         $table->boolean('is_admin')->nullable(false)->default(0);
      });
   }

   #
   # Reverse the migrations.
   #
   # @return void
   #
   public function down()
   {
      Schema::dropIfExists('users');
   }
}
