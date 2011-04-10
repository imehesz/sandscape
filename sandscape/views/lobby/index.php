<?php echo $this->renderPartial('_newGameDlg', array('decks' => $decks)); ?>
<div id="lobby">
    <div id="lobby-left">
        <div id="lobby-users">
            <ul>
                <?php
                foreach ($chat->users as $user) {
                    echo '<li><a href="#">', $user->name, '</a></li>';
                }
                ?>
            </ul>
        </div>
        <div id="lobby-chat">

        </div>
        <div class="clear"></div>
        <div id="lobby-tools">
            <form action="#" method="post">
                <input type="text" id="message" name="message" size="90" />
                <button type="button">Send</button>
            </form>
            <br />
            <?php echo CHtml::link('New Game', '#', array('onclick' => '$("#newgamedlg").dialog("open"); return false;')); ?>
            <?php echo CHtml::link('Join Private', '#', array('onclick' => '$("#joinprivate").dialog("open"); return false;')); ?>
        </div>
    </div>
    <div id="lobby-right">
        <?php foreach ($games as $game) { ?>
            <div class="game">
                <div class="gamehash">
                    <a href="#">#<?php echo $game->hash; ?></a><br />
                    <?php echo $game->created; ?>
                </div>
                <div class="gameicons">
                    <?php
                    if ($game->running) {
                        //echo CHtml::imageButton(Yii::app()->request->baseUrl . '/images/eye.png', array('submit' => 'lobby/join', 'params' => array('gameId' => $game->gameId, 'userId' => 3)));
                    } else {
                        //echo CHtml::imageButton(Yii::app()->request->baseUrl . '/images/arrow_right.png', array('submit' => '', 'params' => array()));
                    }
                    ?>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="clear"></div>
</div>
