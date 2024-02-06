<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
//        \DB::statement('DROP FUNCTION IF EXISTS ReturnLastFormFlow;');
//
//        \DB::statement('
//    CREATE FUNCTION ReturnLastFormFlow (TableName VARCHAR(20), formId INT)
//    RETURNS VARCHAR(20)
//    BEGIN
//        DECLARE flow_slug VARCHAR(20);
//        SET flow_slug = NULL;
//        IF TableName = \'document_flows\' THEN
//            SELECT status_slug INTO flow_slug FROM document_flows WHERE document_id = formId ORDER BY id DESC LIMIT 1;
//        END IF;
//        RETURN flow_slug;
//    END;
//    ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement('drop FUNCTION if EXISTS ReturnLastFormFlow;');
    }
};
