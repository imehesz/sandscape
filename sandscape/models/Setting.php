<?php

/* Setting.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2013, the Sandscape team.
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
 * Model class for the <strong>Setting</strong> table. Stores system wide settings.
 * 
 * Properties for the <em>Setting</em> class:
 * 
 * @property string $key The setting name, identifies this setting
 * @property string $value The setting value
 * @property string $description A text description that explains what this setting does
 * @property string $group
 */
class Setting extends CActiveRecord {

    /**
     * @return Setting
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function rules() {
        return array(
            array('value', 'required'),
            array('value, description', 'length', 'max' => 255),
            array('group', 'length', 'max' => 25)
        );
    }

    public function tableName() {
        return 'Setting';
    }

}