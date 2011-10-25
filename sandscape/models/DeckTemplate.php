<?php

/* DeckTemplate.php
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
 *
 * @property integer $deckTemplateId
 * @property string $name
 * @property string $created
 * @property integer $active
 * 
 * Relations:
 * @property DeckTemplateCard[] $templatesCard
 * 
 * @since 1.1, Green Shield
 */
class DeckTemplate extends CActiveRecord {

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return 'DeckTemplate';
    }

    public function rules() {
        return array(
            array('name', 'required'),
            array('name', 'length', 'max' => 100),
            //search
            array('name', 'safe', 'on' => 'search'),
        );
    }

    public function relations() {
        return array(
            'templatesCard' => array(self::HAS_MANY, 'DeckTemplateCard', 'deckTemplateId'),
        );
    }

    public function attributeLabels() {
        return array(
            'deckTemplateId' => 'ID',
            'name' => 'Name',
            'created' => 'Created',
        );
    }

    public function search() {
        $criteria = new CDbCriteria();

        $criteria->compare('name', $this->name, true);
        $criteria->compare('active', 1);

        return new CActiveDataProvider('DeckTemplate', array('criteria' => $criteria));
    }

}