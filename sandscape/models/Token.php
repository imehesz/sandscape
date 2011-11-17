<?php

/* Token.php
 * 
 * This file is part of Sandscape.
 *
 * Sandscape is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * Sandscape is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with Sandscape.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * Copyright (c) 2011, the Sandscape team and WTactics project.
 * http://wtactics.org
 */

/**
 * A token is an image attached to a card while playing a game. The token as no 
 * meaning to the game engine and users can use tokens for whatever rule they 
 * want. Tokens will be placed above the card's image.
 * 
 * Properties for the <em>Token</em> class:
 * 
 * @property int $tokenId Database ID
 * @property string $name Token name
 * @property string $image Image file name
 * @property integer $active
 * 
 * @see State
 * @since 1.2, Elvish Shaman
 */
class Token extends CActiveRecord {

    /**
     * @return Token
     */
    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'Token';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 150),
            //search
            array('name', 'safe', 'on' => 'search'),
        );
    }

    public function attributeLabels() {
        return array(
            'tokenId' => 'ID',
            'name' => 'Name',
            'image' => 'Image'
        );
    }

    /**
     * @return CActiveDataProvider the data provider that can return the models 
     * based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('Token', array('criteria' => $criteria));
    }

}