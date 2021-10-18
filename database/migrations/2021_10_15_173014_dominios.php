<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Dominios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('dominios')) {
            if (Schema::hasColumn('domainName', 'URLredirect','fechaInicio','usuario')) {
                $table->string('domainName',60)->unique();
                $table->string('URLredirect',2083);
                $table->date('fechaInicio');
                $table->string('usuario',50);
            }else{
                Schema::table('dominios', function (Blueprint $table) {
                $table->string('domainName',60)->unique();
                $table->string('URLredirect',2083);
                $table->date('fechaInicio');
                $table->string('usuario',50);
                });
            }
        }else {
        Schema::create('dominios', function (Blueprint $table) {
            $table->string('domainName',60)->unique();
            $table->string('URLredirect',2083);
            $table->date('fechaInicio');
            $table->string('usuario',50);
        });
    }

        
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::drop('dominios');
    }
}
