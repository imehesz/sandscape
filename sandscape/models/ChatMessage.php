<?php

/* ChatMessage.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
 * 
 * Sandscape's team members are listed in the <CONTRIBUTORS> file.
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 * 
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This is the model class for table "ChatMessage".
 *
 * The followings are the available columns in table 'ChatMessage':
 * @property int $id
 * @property string $message
 * @property string $sentTime
 * @property int $senderId
 * @property int $gameId
 * @property int $system
 *
 * The followings are the available model relations:
 * @property User $sender
 * @property Game $game
 */
class ChatMessage extends CActiveRecord {

    /**
     * @return ChatMessage
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{ChatMessage}}';
    }

    public function relations() {
        return array(
            'sender' => array(self::BELONGS_TO, 'User', 'senderId'),
            'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
        );
    }

    public function attributeLabels() {
        return array(
            'id' => Yii::t('chatmessage', 'ID'),
            'message' => Yii::t('chatmessage', 'Message'),
            'sentTime' => Yii::t('chatmessage', 'Sent Time'),
            'senderId' => Yii::t('chatmessage', 'Sender'),
            'gameId' => Yii::t('chatmessage', 'Game Message'),
            'system' => Yii::t('chatmessage', 'System Message')
        );
    }

    public function isSystemString() {
        return ($this->system ? Yii::t('sandscape', 'Yes') : Yii::t('sandscape', 'No'));
    }

}