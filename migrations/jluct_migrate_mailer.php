<?php

use yii\db\Migration;

class jluct_migrate_mailer extends Migration
{
    public function up()
    {
        $this->createTable('mailer_group', [
            'id' => $this->primaryKey()->comment('id'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'name' => $this->string(240)->notNull()->comment('Название группы'),
            'active' => $this->boolean()->comment('Активность')

        ]);

        $this->createTable('mailer_group_user', [
            'mailer_user_id' => $this->integer()->comment('ID пользователя'),
            'mailer_group_id' => $this->integer()->comment('ID группы'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'PRIMARY KEY(mailer_user_id, mailer_group_id)',
            'active' => $this->boolean()->comment('Активность')

        ]);

        $this->createTable('mailer_user', [
            'id' => $this->primaryKey()->comment('id'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'name' => $this->string(240)->comment('Имя пользователя'),
            'user_id' => $this->integer(12)->comment('ID пользователя'),
            'active' => $this->boolean()->comment('Активность')
        ]);

        $this->createTable('mailer_address', [
            'id' => $this->primaryKey()->comment('id'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'address' => $this->string(240)->comment('Адрес'),
            'mailer_user_id' => $this->integer(12)->notNull()->comment('Группы'),
            'active' => $this->boolean()->comment('Активность')
        ]);

        $this->createTable('mailer_action', [
            'id' => $this->primaryKey()->comment('id'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'name' => $this->string(240)->notNull()->comment('Название действия'),
            'active' => $this->boolean()->comment('Активность')
        ]);

        $this->createTable('mailer_relation', [
            'id' => $this->primaryKey()->comment('id'),
            'date' => $this->timestamp()->comment('Дата создания'),
            'mailer_action_id' => $this->integer(12)->comment('ID действия'),
            'mailer_group_id' => $this->integer(12)->comment('ID группы'),
            'mailer_user_id' => $this->integer(12)->comment('ID пользователя'),
            'mailer_address_id' => $this->integer(12)->comment('ID адреса'),
            'active' => $this->boolean()->comment('Активность')
        ]);


        $this->createIndex(
            'idx-mailer_relation-mailer_action_id',
            'mailer_relation',
            'mailer_action_id'
        );

        $this->addForeignKey(
            'fk-mailer_relation-mailer_action_id',
            'mailer_relation',
            'mailer_action_id',
            'mailer_action',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-mailer_relation-mailer_group_id',
            'mailer_relation',
            'mailer_group_id'
        );

        $this->addForeignKey(
            'fk-mailer_relation-mailer_group_id',
            'mailer_relation',
            'mailer_group_id',
            'mailer_group',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-mailer_relation-mailer_user_id',
            'mailer_relation',
            'mailer_user_id'
        );

        $this->addForeignKey(
            'fk-mailer_relation-mailer_user_id',
            'mailer_relation',
            'mailer_user_id',
            'mailer_user',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-mailer_relation-mailer_address_id',
            'mailer_relation',
            'mailer_address_id'
        );

        $this->addForeignKey(
            'fk-mailer_relation-mailer_address_id',
            'mailer_relation',
            'mailer_address_id',
            'mailer_address',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-mailer_group_user-mailer_group_id',
            'mailer_group_user',
            'mailer_group_id'
        );

        $this->addForeignKey(
            'fk-mailer_group_user-mailer_group_id',
            'mailer_group_user',
            'mailer_group_id',
            'mailer_group',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-mailer_group_user-mailer_user_id',
            'mailer_group_user',
            'mailer_user_id'
        );

        $this->addForeignKey(
            'fk-mailer_group_user-mailer_user_id',
            'mailer_group_user',
            'mailer_user_id',
            'mailer_user',
            'id',
            'CASCADE'
        );


        $this->createIndex(
            'idx-mailer_address-mailer_user_id',
            'mailer_address',
            'mailer_user_id'
        );

        $this->addForeignKey(
            'fk-mailer_address-mailer_user_id',
            'mailer_address',
            'mailer_user_id',
            'mailer_user',
            'id',
            'CASCADE'
        );

        return 0;
    }

    public function down()
    {
        $this->dropTable('mailer_address');
        $this->dropTable('mailer_user');
        $this->dropTable('mailer_group');
        $this->dropTable('mailer_action');
        $this->dropTable('mailer_relation');

        return 0;
    }

    public static function migrate()
    {
        $s = new self;
        $s->up();
    }

    public static function rollback()
    {
        $s = new self;
        $s->down();
    }


}
