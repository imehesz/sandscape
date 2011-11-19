<?php

/* SCGame.php
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
 * @since 1.0, Sudden Growth
 */
class SCGame {

    /**
     *
     * @var SCContainer[]  
     */
    private $all = array();
    private $roots = array();

    /**
     * @var SCToken[]
     */
    private $availableTokens = array();

    /**
     * @var SCState[]
     */
    private $availableStates = array();

    /**
     *
     * @var SCPlayerSide 
     */
    private $player1Side;

    /**
     *
     * @var SCPlayerSide 
     */
    private $player2Side;

    /**
     * If a card is not anywhere, is in void
     * @var SCContainer
     */
    private $void;
    private $player;
    private $opponent;

    /**
     * TODO: document this....
     */
    public function __construct($hasGraveyard, $player1, $player2, $availableTokens, $availableStates, $handWidth = 20, $handHeight = 20, $gameWidth = 100, $gameHeight = 30) {
        $this->player1Side = new SCPlayerSide($this, $player1, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->player2Side = new SCPlayerSide($this, $player2, $hasGraveyard, $handWidth, $handHeight, $gameWidth, $gameHeight);
        $this->void = new SCContainer($this, false, false);

        foreach ($availableTokens as $token)
            $this->availableTokens[$token->getId()] = $token;

        foreach ($availableStates as $state)
            $this->availableStates[$state->getId()] = $state;

        $this->player = null;
        $this->opponent = null;
    }

    public function __wakeup() {
        $this->roots = array();
        $this->player = null;
        $this->opponent = null;
    }

    /**
     *
     * @param SCContainer $c 
     * 
     * @since 1.0, Sudden Growth
     */
    public function register(SCContainer $c) {
        $this->all[$c->getId()] = $c;
    }

    /**
     *
     * @param SCContainer $c 
     * 
     * @since 1.0, Sudden Growth
     */
    public function unregister(SCContainer $c) {
        unset($this->all[$c->getId()]);
    }

    /**
     *
     * @param SCContainer $scc
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getRoot(SCContainer $scc) {
        if (isset($this->roots[$scc->getId()]))
            return $this->roots[$scc->getId()];
        return null;
    }

    /**
     *
     * @param SCDeck $deck 
     * 
     * @since 1.0, Sudden Growth
     */
    public function addPlayer1Deck(SCDeck $deck) {
        $this->player1Side->addDeck($deck);
    }

    /**
     *
     * @param SCDeck $deck 
     * 
     * @since 1.0, Sudden Growth
     */
    public function addPlayer2Deck(SCDeck $deck) {
        $this->player2Side->addDeck($deck);
    }

    /**
     * Returns the current player side.
     * 
     * @param  integer $userId User who originated the request.
     * @return SCPlayerSide 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getPlayerSide($userId) {
        if ($this->player === null) {
            $side = ($this->player1Side->getPlayerId() == $userId ? $this->player1Side :
                            ($this->player2Side->getPlayerId() == $userId ? $this->player2Side : null));

            $this->roots[$side->getHand()->getId()] = $side->getHand();
            $this->roots[$side->getPlayableArea()->getId()] = $side->getPlayableArea();
            if ($side->getGraveyard())
                $this->roots[$side->getGraveyard()->getId()] = $side->getGraveyard();
            foreach ($side->getDecks() as $deck)
                $this->roots[$deck->getId()] = $deck;


            $this->player = $side;
        }


        return $this->player;
    }

    /**
     * Returns the opponent side of the game.
     * 
     * @param  integer $userId  User who originated the request.
     * 
     * @return SCPlayerSide
     * 
     * @since 1.0, Sudden Growth
     */
    public function getOpponentSide($userId) {
        if ($this->opponent === null) {
            $side = ($this->player1Side->getPlayerId() == $userId ? $this->player2Side :
                            ($this->player2Side->getPlayerId() == $userId ? $this->player1Side : null));

            $this->roots [$side->getPlayableArea()->getId()] = $side->getPlayableArea();
            $side->getPlayableArea()->setInvertView(true);

            $this->opponent = $side;
        }
        return $this->opponent;
    }

    public function getVoid() {
        return $this->void;
    }

    /**
     * Returns the cards initialization.
     * 
     * @return array
     * 
     * @since 1.0, Sudden Growth
     */
    public function getCardInitialization() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c instanceof SCCard) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    /**
     * Returns all elements positions.
     * I have the feeling that this one will try to bite me in the ass later. 
     * 
     * @return array
     * 
     * @since 1.0, Sudden Growth
     */
    public function getGameStatus() {
        $update = array();

        foreach ($this->all as $c) {
            if ($c->isMovable()) {
                $update [] = $c->getStatus();
            }
        }

        return $update;
    }

    /**
     *
     * @param int $userId
     * @param string $deck
     * @param bool $toHand
     * 
     * @return SCCard
     * 
     * @since 1.0, Sudden Growth
     */
    public function drawCard($userId, $deck, $toHand = true) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return $player->drawCard($deck, $toHand);
    }

    /**
     *
     * @param type $userId
     * @param type $card
     * @param type $location
     * @param type $xOffset
     * @param type $yOffset
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function moveCard($userId, $card, $location, $xOffset = 0, $yOffset = 0) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $location = isset($this->all[$location]) ? $this->all[$location] : null;

        if ($card && $location && $card instanceof SCCard && $card->isMovable()
                && $location->isDroppable() && $card->getPlayer() == $userId) {

            if ($card !== $location && !$location->isInside($card)) {
                if ($card->getParent())
                    $oldLocation = $card->getParent();
                if ($location->push($card) && $oldLocation) {
                    $oldLocation->remove($card);
                }
            }
            if ($card) {
                $card->setXOffset($xOffset);
                $card->setYOffset($yOffset);
            }
        }

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    /**
     *
     * @param int $userId
     * @param string $card
     * @param string $token
     * 
     * @return stdClass
     * 
     * @since 1.0, Sudden Growth
     */
    public function toggleCardToken($userId, $card, $token) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $token = isset($this->availableTokens[$token]) ? $this->availableTokens[$token] : null;

        if ($card && $token && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleToken($token);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }

        return null;
    }

    /**
     *
     * @param int $userId
     * @param string $card
     * @param string $state
     * 
     * @return stdClass 
     * 
     * @since 1.0, Sudden Growth
     */
    public function toggleCardState($userId, $card, $state) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$card]) ? $this->all[$card] : null;
        $state = isset($this->availableStates[$state]) ? $this->availableStates[$state] : null;

        if ($card && $state && $card instanceof SCCard && $card->getPlayer() == $userId) {
            $card->toggleState($state);

            return (object) array(
                        'update' => $this->getGameStatus()
            );
        }

        return null;
    }

    /**
     *
     * @param type $userId
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function clientUpdate($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return (object) array(
                    'update' => $this->getGameStatus()
        );
    }

    /**
     *
     * @param type $userId
     * @return type 
     * 
     * @since 1.0, Sudden Growth
     */
    public function clientInitialization($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $tokens = array();
        foreach ($this->availableTokens as $token)
            $tokens [] = $token->getInfo();

        $states = array();
        foreach ($this->availableStates as $state)
            $states[] = $state->getInfo();

        return (object) array(
                    'createThis' => (object) array(
                        'nowhere' => (object) array(
                            'id' => $this->void->getId(),
                        ),
                        'player' => (object) array(
                            'hand' => (object) array(
                                'id' => $player->getHand()->getId(),
                            ),
                            'playableArea' => (object) array(
                                'id' => $player->getPlayableArea()->getId(),
                            ),
                            'decks' => $player->getDecksInitialization(),
                            'graveyard' => $player->getGraveyard() ? (object) array(
                                        'id' => $player->getGraveyard()->getId(),
                                    ) : null,
                        ),
                        'opponent' => (object) array(
                            'playableArea' => (object) array(
                                'id' => $opponent->getPlayableArea()->getId(),
                            )
                        ),
                        'cards' => $this->getCardInitialization(),
                    ),
                    'gameInfo' => (object) array(
                        'tokens' => $tokens,
                        'cardStates' => $states
                    )
        );
    }

    /**
     *
     * @param type $cardId
     * @return StdClass 
     * 
     * @since 1.0, Sudden Growth
     */
    public function getCardStatus($userId, $cardId) {
        if (isset($this->all[$cardId])) {
            $player = $this->getPlayerSide($userId);
            $opponent = $this->getOpponentSide($userId);

            return $this->all[$cardId]->getStatus();
        }

        return null;
    }

    /**
     *
     * @param int $userId
     * @param int $cardId
     * 
     * @return SCCard
     * 
     * @since 1.2, Elvish Shaman
     */
    public function flipCard($userId, $cardId) {
        if (isset($this->all[$cardId])) {
            $player = $this->getPlayerSide($userId);
            $opponent = $this->getOpponentSide($userId);

            $this->all[$cardId]->flip();

            return $this->all[$cardId];
        }

        return null;
    }

    /**
     *
     * @param type $userId
     * @param type $deckId
     * @return type 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function shuffleDeck($userId, $deckId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return $player->shuffleDeck($deckId);
    }

    /**
     *
     * @param type $userId
     * @param type $cardId
     * @param type $label
     * @return type 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function placeLabel($userId, $cardId, $label = '') {
        $card = null;
        if (isset($this->all[$cardId])) {
            $player = $this->getPlayerSide($userId);
            $opponent = $this->getOpponentSide($userId);

            $card = $this->all[$cardId];
            $card->setLabel($label);
        }

        //TODO: return game status?
        return $card;
    }

    /**
     *
     * @param type $userId
     * @param type $cardId
     * @return stdClass
     * 
     * @since 1.2, Elvish Shaman
     */
    public function moveToGraveyard($userId, $cardId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $card = isset($this->all[$cardId]) ? $this->all[$cardId] : null;
        if ($card && $card instanceof SCCard && $card->isMovable()
                && $card->getPlayer() == $userId
                && ($grave = $player->getGraveyard()) !== null) {

            if ($card->getParent()) {
                $oldLocation = $card->getParent();
            }

            if ($grave->push($card) && $oldLocation) {
                $card->setFaceUp(false);
                $oldLocation->remove($card);
            }
        }

        return (object) array('update' => $this->getGameStatus());
    }

    /**
     *
     * @param type $userId
     * @param type $toHand
     * @return type 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function drawFromGraveyard($userId, $toHand = true) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        $player->drawFromGraveyard($toHand);

        return (object) array('update' => $this->getGameStatus());
    }

    /**
     *
     * @param type $userId
     * @return bool 
     * 
     * @since 1.2, Elvish Shaman
     */
    public function shuffleGraveyard($userId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return $player->shuffleGraveyard();
    }

    /**
     *
     * @param type $userId
     * @param type $cardId
     * @return SCCard
     * 
     * @since 1.3, Soulharvester
     */
    public function getCard($userId, $cardId) {
        $player = $this->getPlayerSide($userId);
        $opponent = $this->getOpponentSide($userId);

        return (isset($this->all[$cardId]) ? $this->all[$cardId] : null);
    }

    /**
     *
     * @param string $token
     * 
     * @return SCToken
     * 
     * @since 1.3, Soulharvester
     */
    public function getToken($token) {
        return $this->availableTokens[$token];
    }

    /**
     *
     * @param string $state
     * 
     * @return SCState
     * 
     * @since 1.3, Soulharvester
     */
    public function getState($state) {
        return $this->availableStates[$state];
    }

    /**
     *
     * @param SCCounter $counter 
     * 
     * @since 1.3, Soulharvester
     */
    public function addPlayer1Counters(SCCounter $counter) {
        $this->player1Side->addCounter($counter);
    }

    /**
     *
     * @param SCCounter $counter 
     * 
     * @since 1.3, Soulharvester
     */
    public function addPlayer2Counters(SCCounter $counter) {
        $this->player2Side->addCounter($counter);
    }

}