<?php

use yii\db\Migration;

/**
 * Class m180705_144213_alter_table_user_drop_index_unique_on_username
 */
class m180705_144213_alter_table_user_drop_index_unique_on_username extends Migration
{
   public function up()
   {
       $this->dropIndex('username', 'user');
   }

   public function down()
   {
        $this->createIndex('username', 'user', 'username', $unique = true);
   }

}
