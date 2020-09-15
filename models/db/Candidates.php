<?php

namespace app\models\db;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "candidates".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $answers
 * @property int|null $pictureId
 * @property string|null $picturePath
 * @property int|null $committeeId
 * @property string|null $metaData
 * @property int|null $votingListId
 *
 * @property VotingList $votingList
 */
class Candidates extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName() : string
    {
        return 'candidates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() : array
    {
        return [
            [['answers', 'metaData'], 'string'],
            [['pictureId', 'committeeId', 'votingListId'], 'integer'],
            [['name', 'picturePath'], 'string', 'max' => 255],
            [['votingListId'], 'exist', 'skipOnError' => true, 'targetClass' => VotingList::class, 'targetAttribute' => ['votingListId' => 'id']],
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
            'answers' => Yii::t('app', 'Answers'),
            'pictureId' => Yii::t('app', 'Picture ID'),
            'picturePath' => Yii::t('app', 'Picture Path'),
            'committeeId' => Yii::t('app', 'Committee ID'),
            'metaData' => Yii::t('app', 'Meta Data'),
            'votingListId' => Yii::t('app', 'Voting List ID'),
        ];
    }

    /**
     * Gets query for [[VotingList]].
     *
     * @return ActiveQuery
     */
    public function getVotingList() : ActiveQuery
    {
        return $this->hasOne(VotingList::class, ['id' => 'votingListId']);
    }
}
