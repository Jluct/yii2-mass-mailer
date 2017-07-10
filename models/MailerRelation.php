<?php

namespace jluct\mailer\models;

use Yii;

/**
 * This is the model class for table "mailer_relation".
 *
 * @property integer $id
 * @property string $date
 * @property integer $mailer_action_id
 * @property integer $mailer_group_id
 * @property integer $mailer_user_id
 * @property integer $mailer_address_id
 * @property integer $active
 *
 * @property MailerAction $mailerAction
 * @property MailerAddress $mailerAddress
 * @property MailerGroup $mailerGroup
 * @property MailerUser $mailerUser
 */
class MailerRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['mailer_action_id', 'mailer_group_id', 'mailer_user_id', 'mailer_address_id', 'active'], 'integer'],
            [['mailer_action_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailerAction::className(), 'targetAttribute' => ['mailer_action_id' => 'id']],
            [['mailer_address_id'], 'exist', 'skipOnError' => true, 'targetClass' => MailerAddress::className(), 'targetAttribute' => ['mailer_address_id' => 'id']],
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
            'id' => 'id',
            'date' => 'Дата создания',
            'mailer_action_id' => 'ID действия',
            'mailer_group_id' => 'ID группы',
            'mailer_user_id' => 'ID пользователя',
            'mailer_address_id' => 'ID адреса',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerAction()
    {
        return $this->hasOne(MailerAction::className(), ['id' => 'mailer_action_id'])->inverseOf('mailerRelations');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerAddress()
    {
        return $this->hasOne(MailerAddress::className(), ['id' => 'mailer_address_id'])->inverseOf('mailerRelations');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerGroup()
    {
        return $this->hasOne(MailerGroup::className(), ['id' => 'mailer_group_id'])->inverseOf('mailerRelations');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerUser()
    {
        return $this->hasOne(MailerUser::className(), ['id' => 'mailer_user_id'])->inverseOf('mailerRelations');
    }
}
