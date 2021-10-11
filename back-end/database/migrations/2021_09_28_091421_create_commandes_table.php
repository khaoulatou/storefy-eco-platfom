<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommandesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->string('destinataire');
            $table->string('phone1');
            $table->string('phone2');
            $table->string('ville_customer');
            $table->string('addresse');
            $table->integer('status');
            // $table->foreignId('statut_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commandes');
    }
}
