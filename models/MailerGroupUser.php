<?php

namespace jluct\mailer\models;


use Yii;

/**
 * This is the model class for table "mailer_group_user".
 *
 * @property integer $mailer_user_id
 * @property integer $mailer_group_id
 * @property string $date
 * @property integer $active
 *
 * @property MailerGroup $mailerGroup
 * @property MailerUser $mailerUser
 */
class MailerGroupUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_group_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mailer_user_id', 'mailer_group_id'], 'required'],
            [['mailer_user_id', 'mailer_group_id', 'active'], 'integer'],
            [['date'], 'safe'],
            [['mailer_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailerGroup::className(), 'targetAttribute' => ['mailer_group_id' => 'id']],
            [['mailer_user_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailerUser::className(), 'targetAttribute' => ['mailer_user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mailer_user_id' => 'ID пользователя',
            'mailer_group_id' => 'ID группы',
            'date' => 'Дата создания',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerGroup()
    {
        return $this->hasOne(MailerGroup::className(), ['id' => 'mailer_group_id'])->inverseOf('mailerGroupUsers');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerUser()
    {
        return $this->hasOne(MailerUser::className(), ['id' => 'mailer_user_id'])->inverseOf('mailerGroupUsers');
    }
}
