<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSortiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sorties', function (Blueprint $table) {
            $table->id();

            $table->decimal('qte', 10,2);
             $table->foreignId('unity_id');
            $table->foreignId('famille_id');
            $table->foreignId('user_id');
            $table->foreignId('updated_by')->nullable();
            $table->foreignId('product_id');
            $table->date('date_consomation');
            $table->foreignId('destinataire');
            $table->foreignId('destination');
            $table->string('observation')->nullable();
            $table->foreignId('exercice_id')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('sorties');
    }
}
