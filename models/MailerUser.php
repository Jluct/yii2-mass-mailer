<?php

namespace jluct\mailer\models;


use Yii;

/**
 * This is the model class for table "mailer_user".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property integer $user_id
 * @property integer $active
 *
 * @property MailerAddress[] $mailerAddresses
 * @property MailerGroupUser[] $mailerGroupUsers
 * @property MailerGroup[] $mailerGroups
 * @property MailerRelation[] $mailerRelations
 */
class MailerUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['user_id', 'active'], 'integer'],
            [['name'], 'string', 'max' => 240],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'date' => 'Дата создания',
            'name' => 'Имя пользователя',
            'user_id' => 'ID пользователя',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerAddresses()
    {
        return $this->hasMany(MailerAddress::className(), ['mailer_user_id' => 'id'])->inverseOf('mailerUser');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerGroupUsers()
    {
        return $this->hasMany(MailerGroupUser::className(), ['mailer_user_id' => 'id'])->inverseOf('mailerUser');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerGroups()
    {
        return $this->hasMany(MailerGroup::className(), ['id' => 'mailer_group_id'])->viaTable('mailer_group_user', ['mailer_user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerRelations()
    {
        return $this->hasMany(MailerRelation::className(), ['mailer_user_id' => 'id'])->inverseOf('mailerUser');
    }
}
