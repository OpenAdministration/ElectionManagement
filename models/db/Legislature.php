<?php

namespace app\models\db;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "legislature".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $start
 * @property string|null $end
 * @property string|null $questionDeadline
 *
 * @property Committees[] $committees
 */
class Legislature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return 'legislature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['start', 'end', 'questionDeadline'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() : array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'start' => Yii::t('app', 'Start'),
            'end' => Yii::t('app', 'End'),
            'questionDeadline' => Yii::t('app', 'Question Deadline'),
        ];
    }

    /**
     * Gets query for [[Committees]].
     *
     * @return ActiveQuery
     */
    public function getCommittees() : ActiveQuery
    {
        return $this->hasMany(Committees::class, ['legislatureId' => 'id']);
    }
}
