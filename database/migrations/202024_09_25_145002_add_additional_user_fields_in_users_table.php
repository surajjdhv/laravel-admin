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
        Schema::table('users', function (Blueprint $table) {
            $table->string('type')->default('standard')->after('remember_token');
            $table->unsignedBigInteger('created_by')
                ->nullable()
                ->after('type');
            $table->unsignedBigInteger('updated_by')
                ->nullable()
                ->after('created_by');
            $table->boolean('is_active')->default(true)->after('type');
            $table->softDeletes()->after('updated_at');

            $table->foreign('created_by')
                ->references('id')
                ->on('users');
            
            $table->foreign('updated_by')
                ->references('id')
                ->on('users');
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
            $table->dropColumn([
                'type',
                'is_active',
                'created_by',
                'updated_by',
                'deleted_at'
            ]);
        });
    }
};
