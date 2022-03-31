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
        Schema::table('object_picture', function (Blueprint $table) {
            $table->foreignId('object_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('picture_id')->nullable()->constrained()->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('object_picture', function (Blueprint $table) {
            $table->dropConstrainedForeignId('object_id');
            $table->dropConstrainedForeignId('picture_id');
        });
    }
};
