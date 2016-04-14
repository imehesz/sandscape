<?php

/* Deck.php
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

namespace engine\models;

/**
 * @author Pedro Serra
 * @copyright (c) 2016, WTactics Project
 */
final class Deck extends Container {

    private $dbId;
    private $name;

    /**
     *
     * @param SCGame $game
     * @param string $name
     * @param SCCard[] $cards 
     */
    public function __construct(SCGame $game, $name, $cards, $dbId) {
        parent::__construct($game, false, false);
        $this->name = $name;
        $this->dbId = $dbId;

        foreach ($cards as $c)
            $this->push($c);
    }

    /**
     *
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     *
     * @return int
     */
    public function getDbId() {
        return $this->dbId;
    }

}
