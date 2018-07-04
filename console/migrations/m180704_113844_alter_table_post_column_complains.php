<?php

use yii\db\Migration;

/**
 * Class m180704_113844_alter_table_post_column_complains
 */
class m180704_113844_alter_table_post_column_complains extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->addColumn('{{%post}}', 'complaints', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropColumn('{{%post}}', 'complaints');

        return false;
    }

}
