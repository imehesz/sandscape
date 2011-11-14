<?php

/* SCPlayerSide.php
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
 * A player side, with the player's decks, graveyard and hand. This class contains
 * all the elements that belong to a given player. There should be 2 player sides
 * per game and each will keep track of it's own cards, decks, graveyards and 
 * anything else that a player owns.
 * 
 * @since 1.0, Sudden Growth
 */
class SCPlayerSide {

    private $game;
    private $playerId;
    private $decks;
    private $graveyard;
    private $hand;
    private $playableArea;

    public function __construct(SCGame $game, $playerId, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight) {
        $this->game = $game;
        $this->playerId = $playerId;
        $this->hand = new SCContainer($game, false, true); // new SCGrid($game, $handHeight, $handWidth);
        $this->playableArea = new SCContainer($game, false, true); // new SCGrid($game, $gameHeight, $gameWidth);
        if ($hasGraveyard)
            $this->graveyard = new SCGraveyard($game);

        $this->decks = array();
    }

    /**
     *
     * @param SCDeck $deck 
     * 
     * @since 1.0, Sudden Growth
     */
    public function addDeck(SCDeck $deck) {
        $this->decks[$deck->getId()] = $deck;
    }

    /**
     *
     * @return int
     * 
     * @since 1.0, Sudden Growth
     */
    public function getPlayerId() {
        return $this->playerId;
    }

    /**
     *
     * @return SCGraveyard
     * 
     * @since 1.0, Sudden Growth
     */
    public function getGraveyard() {
        return $this->graveyard;
    }

    /**
     *
     * @return SCContainer
     * 
     * @since 1.0, Sudden Growth
     */
    public function getHand() {
        return $this->hand;
    }

    /**
     *
     * @return SCContainer
     * 
     * @since 1.0, Sudden Growth
     */
    public function getPlayableArea() {
        return $this->playableArea;
    }

    /**
     *
     * @return array 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getDecks() {
        return $this->decks;
    }

    /**
     *
     * @return array 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getDecksInitialization() {
        $output = array();
        foreach ($this->decks as $deck) {
            $output [] = (object) array(
                        'id' => $deck->getId(),
                        'name' => $deck->getName(),
            );
        }
        return $output;
    }

    /**
     *
     * @param string $deckId
     * @param bool $toHand 
     * 
     * @since 1.0, Sudden Growth
     */
    public function drawCard($deckId, $toHand = true) {
        if (isset($this->decks[$deckId])) {
            $deck = $this->decks[$deckId];
            $card = $deck->pop();
            if ($card) {
                $card->setMovable(true);
                if ($toHand) {
                    $card->setFaceUp(true);
                    $this->hand->push($card);
                } else {
                    $this->playableArea->push($card);
                }
            }
        }
    }

    /**
     *
     * @param string $deckId
     * @return type 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function shuffleDeck($deckId) {
        if (isset($this->decks[$deckId])) {
            return $this->decks[$deckId]->shuffle();
        }

        return false;
    }

    /**
     *
     * @param bool $toHand 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function drawFromGraveyard($toHand = true) {
        if ($this->graveyard) {
            $card = $this->graveyard->pop();
            if ($card) {
                $card->setMovable(true);
                if ($toHand) {
                    $card->setFaceUp(true);
                    $this->hand->push($card);
                } else {
                    $this->playableArea->push($card);
                }
            }
        }
    }

    /**
     *
     * @return bool
     * 
     * @since 1.2, Elvish Shaman
     */
    public function shuffleGraveyard() {
        if ($this->graveyard) {
            return $this->graveyard->shuffle();
        }

        return false;
    }

}