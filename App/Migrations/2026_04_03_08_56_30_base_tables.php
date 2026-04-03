<?php

use Cube\Data\Database\Database;
use Cube\Data\Database\Migration\Migration;
use Cube\Data\Database\Migration\Plan;
use Cube\Data\Models\ModelField;

return new class extends Migration
{
    public function up(Plan $plan, Database $database) {
        $database->exec(
            "CREATE TABLE directory (
                uuid CHAR(36) PRIMARY KEY DEFAULT (UUID()),
                path VARCHAR(255) NOT NULL,
                password_hash VARCHAR(100) NULL
            )
        ");
    }

    public function down(Plan $plan, Database $database) {

    }
};