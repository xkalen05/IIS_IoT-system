<?php

// database/migrations/xxxx_xx_xx_create_system_sharing_requests_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemSharingRequestsTable extends Migration
{
    public function up()
    {
        Schema::create('system_sharing_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('system_id');
            $table->unsignedBigInteger('request_user_id'); // User who initiated the request
            $table->unsignedBigInteger('system_owner_id');
            $table->timestamps();

            $table->foreign('system_id')->references('id')->on('systems')->onDelete('cascade');
            $table->foreign('system_owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('request_user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_sharing_requests');
    }
}

