<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER staff_auto BEFORE INSERT ON users
        FOR each ROW
        BEGIN
           SET NEW.id = getNextCustomSeq("user","BKS");
        END
        ');

        DB::unprepared('
        CREATE TRIGGER student_auto BEFORE INSERT ON students
        FOR each ROW
        BEGIN
           SET NEW.id = getNextCustomSeq("student","BKA");
        END
        ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trigger');
    }
}
