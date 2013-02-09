<?php

/* SessionData.php
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
 * The <strong>SessionData</strong> table stores session information for 
 * authenticated users. The table is queried to determine what users are active 
 * and allows security tokens to be stored.
 * 
 * Properties for the <em>SessionData</em> class:
 * 
 * @property integer $id
 * @property string $token
 * @property string $tokenExpires
 * @property string $lastActivity
 * @property integer $userId
 * 
 * @property User $user The owner of this session data.
 */
class SessionData extends CActiveRecord {

    /**
     * @return SessionData
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{SessionData}}';
    }

    public function relations() {
        return array(
            'user' => array(self::BELONGS_TO, 'User', 'userId')
        );
    }

}