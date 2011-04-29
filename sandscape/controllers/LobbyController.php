<?php
/*
 * Controller.php
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
 */
class LobbyController extends Controller {

    private $chat;

    public function __construct($id, $module = null) {
        parent::__construct($id, $module);

        $this->chat = Chat::model()->find('lobby = 1');

        if (!$this->chat) {
            $this->chat = new Chat();
            $this->chat->lobby = 1;
            $this->chat->save();
        }
    }

    public function accessRules() {
        return array_merge(array(
            array(
                'allow',
                'actions' => array('index', 'create', 'search', 'join', 'send'),
                'users' => array('@')
                )), parent::accessRules());
    }

    public function actionIndex() {

        $criteria = new CDbCriteria();

        $criteria->select = 'playerA, created, started, hash';
        $criteria->condition = 'private = 0 AND ended IS NULL';

        $viewData = array(
            'chat' => $this->chat,
            'games' => Game::model()->findAll($criteria),
            //TODO: change this to use the authenticated user....
            'decks' => Deck::model()->findAll('userId = :id', array(':id' => 2))
        );

        $this->render('index', $viewData);
    }

    public function actionCreate() {

        if (isset($_POST['ajax']) && $_POST['ajax'] == 'newgame-form') {
            $now = date('Y-m-d H:i:s');

            $game = new Game();
            $game->currentState = serialize(new WTSGame());

            $chat = new Chat();
            $chat->lobby = 0;
            $chat->started = $now;
            $chat->save();

            $game->chatId = $chat->chatId;

            //TODO: change this to use the authenticated user and correct deck ID....
            $deckId = (int) $_POST['deck'];
            $creator = User::model()->findByPk(2);
            $deck = Deck::model()->findByPk($deckId);

            $game->playerA = $creator->userId;
            $game->deckA = $deck->deckId;
            $game->created = $now;

            if (isset($_POST['private']) && (int) $_POST['private'])
                $game->private = 1;

            $game->hash = dechex(crc32(($now . 2 . $creator->name . $deck->name . $game->private)));

            //TODO: validation and messages...
            $game->save();
        }
    }

    public function actionSearch() {
        
    }

    public function actionJoin() {
        var_dump($_POST);
        die;
    }

    public function actionSend() {
        if ($this->chat) {
            $message = new ChatMessage();
            $message->message = '';
            $message->sent = date('Y-m-d H:m:s');
            $message->user = null;
            $message->chat = null;
            $message->save();
        }
    }

}

