<?php

use App\Contracts\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateChEventsTables
 */
class CreateChEventsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('ch_events')) {
            Schema::create('ch_events', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->text('description')->nullable();
                $table->string('banner_url')->nullable();
                $table->string('route_code')->nullable();
                $table->dateTime('starting_at');
                $table->dateTime('ending_at');
                $table->timestamps();
                $table->softDeletes();
            });
        }
        if (!Schema::hasTable('ch_event_user')) {
            Schema::create('ch_event_user', function (Blueprint $table) {
                $table->id();
                $table->foreignId('event_id');
                $table->foreignId('user_id');
            });
        }
        if (!Schema::hasTable('ch_event_matrix')) {
            Schema::create('ch_event_matrix', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable();
                $table->foreignId('event_id');
                $table->string('flight_id')->nullable();
                $table->string('pirep_id')->nullable();
                $table->foreign('event_id')->references('id')->on('ch_events')->cascadeOnDelete();
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
        Schema::dropIfExists('ch_events');
        Schema::dropIfExists('ch_event_user');
        Schema::dropIfExists('ch_event_user_matrix');
    }
}
