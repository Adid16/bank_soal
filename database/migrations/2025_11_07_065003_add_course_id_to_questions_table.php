<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/XXXX_add_course_id_to_questions_table.php

public function up()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->foreignId('course_id') // <-- Foreign key ke tabel 'courses'
              ->nullable()
              ->constrained('courses') // Menghubungkan ke tabel 'courses'
              ->onDelete('set null')
              ->after('id');
    });
}

public function down()
{
    Schema::table('questions', function (Blueprint $table) {
        $table->dropForeign(['course_id']);
        $table->dropColumn('course_id');
    });
}
};
