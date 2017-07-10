<?php

namespace jluct\mailer\models;

use Yii;

/**
 * This is the model class for table "mailer_address".
 *
 * @property integer $id
 * @property string $date
 * @property string $address
 * @property integer $mailer_user_id
 * @property integer $active
 *
 * @property MailerUser $mailerUser
 * @property MailerRelation[] $mailerRelations
 */
class MailerAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['mailer_user_id'], 'required'],
            [['mailer_user_id', 'active'], 'integer'],
            [['address'], 'string', 'max' => 240],
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
            'address' => 'Адрес',
            'mailer_user_id' => 'Группы',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerUser()
    {
        return $this->hasOne(MailerUser::className(), ['id' => 'mailer_user_id'])->inverseOf('mailerAddresses');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerRelations()
    {
        return $this->hasMany(MailerRelation::className(), ['mailer_address_id' => 'id'])->inverseOf('mailerAddress');
    }
}
