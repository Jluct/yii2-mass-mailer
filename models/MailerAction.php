<?php

namespace jluct\mailer\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "mailer_action".
 *
 * @property integer $id
 * @property string $date
 * @property string $name
 * @property integer $active
 *
 * @property MailerRelation[] $mailerRelations
 */
class MailerAction extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mailer_action';
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
            'name' => 'Название действия',
            'active' => 'Активность',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMailerRelations()
    {
        return $this->hasMany(MailerRelation::className(), ['mailer_action_id' => 'id'])->inverseOf('mailerAction');
    }


    public static function getAddressForAction($id)
    {
        $query = Yii::$app->db->createCommand('
            SELECT `mailer_address`.`address`, `mailer_user`.`name` FROM mailer_action
LEFT JOIN mailer_relation on mailer_relation.mailer_action_id = mailer_action.id
LEFT JOIN mailer_group on mailer_group.id = mailer_relation.mailer_group_id
LEFT JOIN mailer_group_user on mailer_group_user.mailer_group_id = mailer_group.id
LEFT JOIN mailer_user ON mailer_user.id = mailer_group_user.mailer_user_id
LEFT JOIN mailer_address ON mailer_address.mailer_user_id = mailer_user.id
WHERE mailer_action.id = :id', ['id' => $id]);

        return $query->queryAll();
    }
    
}
