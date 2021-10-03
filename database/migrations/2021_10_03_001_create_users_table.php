<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


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
         $table->collation = 'utf8mb4_unicode_ci'; # Same as the general setting in /config/database.php

         $table->increments('id'); # UNSIGNED INTEGER AUTO-INCREMENT
         $table->tinyText('name')->nullable(false);
         $table->tinyText('email')->nullable(false);
         $table->string('password');
         $table->dateTime('reg_datetime')->nullable(false);
         $table->string('google_id')->nullable(true)->default(null);
         $table->tinyText('verification_code')->nullable(false);
         $table->dateTime('vercode_datetime')->nullable(false);
         $table->boolean('is_emailverified')->nullable(false)->default(0);
         $table->tinyText('resetpw_code')->nullable(true)->default(null);
         $table->dateTime('rpwcode_datetime')->nullable(true)->default(null);
         $table->text('ipaddrs_obj')->nullable(false);
         $table->rememberToken();
         $table->string('picture')->nullable(false);
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
