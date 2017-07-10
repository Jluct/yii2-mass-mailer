<?php

namespace jluct\mailer\models;


use Yii;

/**
 * This is the model class for table "mailer_group".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property integer $active
 *
 * @property MailerGroupUser[] $mailerGroupUsers
 * @property MailerUser[] $mailerUsers
 * @property MailerRelation[] $mailerRelations
 */
class MailerGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['date'], 'safe'],
            [['name'], 'required'],
            [['active'], 'integer'],
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
            'name' => 'Название группы',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerGroupUsers()
    {
        return $this->hasMany(MailerGroupUser::className(), ['mailer_group_id' => 'id'])->inverseOf('mailerGroup');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerUsers()
    {
        return $this->hasMany(MailerUser::className(), ['id' => 'mailer_user_id'])->viaTable('mailer_group_user', ['mailer_group_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerRelations()
    {
        return $this->hasMany(MailerRelation::className(), ['mailer_group_id' => 'id'])->inverseOf('mailerGroup');
    }

    public static function getAddressForGroup($id)
    {
        $query = Yii::$app->db->createCommand('
            SELECT `mailer_address`.`address`, `mailer_user`.`name` FROM mailer_group
LEFT JOIN mailer_group_user on mailer_group_user.mailer_group_id = mailer_group.id
LEFT JOIN mailer_user ON mailer_user.id = mailer_group_user.mailer_user_id
LEFT JOIN mailer_address ON mailer_address.mailer_user_id = mailer_user.id
WHERE mailer_group.id = :id', ['id' => $id]);

        return $query->queryAll();
    }

}
