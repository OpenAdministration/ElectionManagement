<?php

namespace app\models\db;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "votingList".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $shortName
 * @property string|null $answers
 *
 * @property Candidates[] $candidates
 */
class VotingList extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return 'votingList';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['answers'], 'string'],
            [['name', 'shortName'], 'string', 'max' => 255],
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
            'shortName' => Yii::t('app', 'Short Name'),
            'answers' => Yii::t('app', 'Answers'),
        ];
    }

    /**
     * Gets query for [[Candidates]].
     *
     * @return ActiveQuery
     */
    public function getCandidates() : ActiveQuery
    {
        return $this->hasMany(Candidates::class, ['votingListId' => 'id']);
    }
}
