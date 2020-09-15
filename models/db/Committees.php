<?php

namespace app\models\db;

use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "committees".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $memberCount
 * @property int|null $voteMember
 * @property int|null $noVoteMember
 * @property int|null $voteCount
 * @property int|null $selfApply
 * @property int|null $legislatureId
 * @property int|null $listVote
 * @property string|null $questionCandidate
 * @property string|null $questionList
 *
 * @property Legislature $legislature
 */
class Committees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return 'committees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['memberCount', 'voteMember', 'noVoteMember', 'voteCount', 'selfApply', 'legislatureId', 'listVote'], 'integer'],
            [['questionCandidate', 'questionList'], 'string'],
            [['name'], 'string', 'max' => 255],
            [['legislatureId'], 'exist', 'skipOnError' => true, 'targetClass' => Legislature::className(), 'targetAttribute' => ['legislatureId' => 'id']],
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
            'memberCount' => Yii::t('app', 'Member Count'),
            'voteMember' => Yii::t('app', 'Vote Member'),
            'noVoteMember' => Yii::t('app', 'No Vote Member'),
            'voteCount' => Yii::t('app', 'Vote Count'),
            'selfApply' => Yii::t('app', 'Self Apply'),
            'legislatureId' => Yii::t('app', 'legislature ID'),
            'listVote' => Yii::t('app', 'List Vote'),
            'questionCandidate' => Yii::t('app', 'Question Candidate'),
            'questionList' => Yii::t('app', 'Question List'),
        ];
    }

    /**
     * Gets query for [[legislature]].
     *
     * @return ActiveQuery
     */
    public function getLegislature() : ActiveQuery
    {
        return $this->hasOne(Legislature::class, ['id' => 'legislatureId']);
    }
}
