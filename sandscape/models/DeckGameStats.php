<?php

/* DeckGameStats.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011, the Sandscape team.
 * 
 * Sandscape uses several third party libraries and resources, a complete list 
 * can be found in the <README> file and in <_dev/thirdparty/about.html>.
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
 * @property int $deckId
 * @property int $gameId
 * @property float $rating
 * @property string $notes
 *
 * @property Deck $deck
 * @property Game $game
 * 
 * @since 1.3, Soulharvester
 */
class DeckGameStats extends CActiveRecord {

    /**
     * @return DeckGameStats
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'DeckGameStats';
    }

    public function relations() {
        return array(
            'game' => array(self::BELONGS_TO, 'Game', 'gameId'),
            'deck' => array(self::BELONGS_TO, 'Deck', 'deckId'),
        );
    }

    public function attributeLabels() {
        return array(
            'gameId' => 'Game ID',
            'deckId' => 'Dice ID',
            'rating' => 'Rating',
            'notes' => 'Notes'
        );
    }

}