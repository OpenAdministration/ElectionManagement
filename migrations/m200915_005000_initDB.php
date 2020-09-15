<?php


namespace app\migrations;


class m200915_005000_initDB extends \yii\db\Migration
{
    public function up() : bool
    {
        // this is useless example code - please describe your own tables
        $this->createTable('exampleTable', [
            'id' => $this->primaryKey(),
            'timestamp' => $this->timestamp(),
        ]);
        return true;
    }

    public function down() : bool
    {
        // undo
        $this->dropTable('exampleTable');
    }
}