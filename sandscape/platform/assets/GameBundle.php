<?php

/*
 * GameBundle.php
 * 
 * This file is part of Sandscape, a virtual, browser based, table allowing 
 * people to play a customizable card games (CCG) online.
 *
 * Copyright (c) 2011 - 2016, WTactics Project <http://wtactics.org>
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

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Sérgio Lopes <knitter.is@gmail.com>
 * @copyright (c) 2016, WTactics Project
 */
class GameBundle extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [];
    public $depends = [ 'yii\web\JqueryAsset'];

    public function __construct($config = []) {
        if (defined('YII_ENV') && YII_ENV == 'dev') {
            $this->js[] = 'js/game.js';
            $this->css[] = 'css/game.css';
        } else {
            $this->js[] = 'js/game.min.js';
            $this->css[] = 'css/game.min.css';
        }

        parent::__construct($config);
    }

}
