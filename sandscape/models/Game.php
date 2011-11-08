<?php

/* Game.php
 * 
 * This file is part of SandScape.
 *
 * SandScape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * SandScape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with SandScape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the SandScape team and WTactics project.
 * http://wtactics.org
 */

/**
 * This is the model class for table "Game".
 *
 * The followings are the available columns in table 'Game':
 * @property integer $gameId
 * @property integer $player1
 * @property integer $player2
 * @property string $created
 * @property string $started
 * @property string $ended
 * @property integer $running
 * @property integer $paused
 * @property string $state
 * 
 * @property integer $maxDecks
 * @property integer $graveyard
 * @property integer $player1Ready
 * @property integer $player2Ready
 * 
 * @property integer $lastChange
 * @property integer $acceptUser
 * @property integer $winnerId
 * @property integer $spectatorsSpeak
 *
 * The followings are the available model relations:
 * @property ChatMessage[] $chatMessages
 * @property User $player10
 * @property User $player20
 * @property Deck $decks
 * @property Dice $dice
 * @property User $winner
 * 
 * @since 1.0, Sudden Growth
 */
class Game extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @return Game the static model class
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Game';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('running, paused', 'numerical', 'integerOnly' => true),
            array('started, ended', 'safe'),
            //search
            array(
                'player1, player2, created, started, ended, running, paused, winnerId',
                'safe',
                'on' => 'search'
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        return array(
            'chatMessages' => array(self::HAS_MANY, 'ChatMessage', 'gameId'),
            'player10' => array(self::BELONGS_TO, 'User', 'player1'),
            'player20' => array(self::BELONGS_TO, 'User', 'player2'),
            'decks' => array(self::MANY_MANY, 'Deck', 'GameDeck(gameId, deckId)'),
            'dice' => array(self::MANY_MANY, 'Dice', 'GameDice(gameId, diceId)'),
            'winner' => array(self::BELONGS_TO, 'User', 'winnerId'),
            'accept' => array(self::BELONGS_TO, 'User', '$acceptUser'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'gameId' => 'ID',
            'player1' => 'Player 1',
            'player2' => 'Player 2',
            'created' => 'Created',
            'started' => 'Started',
            'ended' => 'Ended',
            'running' => 'Running',
            'paused' => 'Paused',
            'maxDecks' => 'Max. number of decks',
            'graveyard' => 'Game has graveyard',
            'player1Ready' => 'Player 1 is ready',
            'player2Ready' => 'Player 2 is ready',
            'acceptUser' => 'Accept only',
            'winnerId' => 'Winner'
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * A filter is just an <em>Card</em> instance whose attribute values are used 
     * to limit the search criteria.
     * 
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('player1', $this->player1);
        $criteria->compare('player2', $this->player2);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('started', $this->started, true);
        $criteria->compare('ended', $this->ended, true);
        $criteria->compare('running', $this->running);
        $criteria->compare('paused', $this->paused);
        $criteria->compare('winnerId', $this->winnerId);

        return new CActiveDataProvider('Game', array('criteria' => $criteria));
    }

}