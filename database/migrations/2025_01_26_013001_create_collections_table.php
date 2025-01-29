<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collections', function (Blueprint $table) {
            $table->id(); // ID automatique pour la collection
            $table->string('collection'); // Nom de la collection
            $table->boolean('is_active')->default(false); // Statut de la collection, désactivée par défaut
            $table->timestamps(); // Champs created_at et updated_at
        });
    }

    /**
     * Inverser la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collections');
    }
}
