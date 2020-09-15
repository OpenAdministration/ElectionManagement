<?php


//namespace app\migrations;


class m200915_005000_initDB extends \yii\db\Migration
{
    public function up() : bool
    {
        // this is useless example code - please describe your own tables
        $this->createTable('legislature', [
            'id' => $this->primaryKey(),
            'name' => $this ->string(),
            'start'=> $this->date(),
            'end'=> $this->date(),
            'questionDeadline'=> $this->dateTime(),
        ]);

        $this->createTable('committees', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'memberCount' => $this->integer(),
            'voteMember' => $this->integer(),
            'noVoteMember' => $this->integer(),
            'voteCount' => $this->integer(),
            'selfApply' => $this->boolean(),
            'legislatureId' => $this->integer(),
            'listVote'=> $this->boolean(),
            'questionCandidate' => $this->json(),
            'questionList' => $this->json(),
        ]);

        $this->addForeignKey('fk_committees_legislature', 'committees', 'legislatureId', 'legislature', 'id');


        $this->createTable('candidates', [
            'id'=> $this->primaryKey(),
            'name'=> $this->string(),
            'answers'=> $this->json(),
            'pictureId'=> $this->integer(),
            'picturePath'=> $this->string(),
            'committeeId' => $this->integer(),
            'metaData' => $this->json(),
            'votingListId' => $this->integer(),
        ]);

        $this->createTable('votingList', [
            'id'=> $this->primaryKey(),
            'name'=> $this->string(),
            'shortName' => $this->string(),
            'answers' => $this->text(),

        ]);

        $this->addForeignKey('fk_candidates_votingList', 'candidates', 'votingListId', 'votingList', 'id');

        return true;
    }

    public function down() : bool
    {
        // undo
        $this->dropTable('exampleTable');
    }
}