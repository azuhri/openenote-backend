<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->string("id")->primary();
            $table->string("user_id")->index();
            $table->foreign("user_id")->references("id")->on("users");
            $table->string("title");
            $table->enum("share_type", ["off","show","edit"])->default("off");
            $table->longText("content");
            $table->string("public_can_edit_link")->index();
            $table->string("public_show_link")->index();
            $table->timestamps();
        });

        // Schema::table('notes', function (Blueprint $table) {
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
