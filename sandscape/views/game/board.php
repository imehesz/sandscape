<?php
Yii::app()->clientScript->registerCoreScript('jquery');
Yii::app()->clientScript->registerCoreScript('jquery.ui');
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.bubblepopup.v2.3.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.jgrowl.minimized.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/jquery.simplemodal.1.4.1.min.js', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScriptFile('_resources/js/game.js', CClientScript::POS_HEAD);

$url = $this->createURL('game/play', array('id' => $gameId));
Yii::app()->clientScript->registerScript('startjs', "initTable('{$url}')");
?>

<div id="top">
    <div id="info-widget">
        <div id="tools-widget">
            <a href="javascript:;" onclick="showChat();">Chat</a>
            <a href="<?php echo $this->createURL('game/leave', array('id' => $gameId)); ?>">Leave</a>
        </div>
        <table id="card-info">
            <tr>
                <td colspan="2"><strong>Card:</strong> name</td>
            </tr>
            <tr  style="vertical-align: top;">
                <td style="width: 30%;"><img src="_cards/up/thumbs/cardback.jpg" /></td>
                <td>
                    <strong>States:</strong>
                </td>
            </tr>
            <tr colspane="2">
                <td>
                    <strong>Rules:</strong>
                </td>
            </tr>
        </table>
        <a id="inspect-card" href="javascript:;" onclick="inspect();">Inspect</a>
    </div>
    <div class="opponent-area"></div>
    <div style="clear: both"></div>
</div>
<div id="bottom" style="">
    <div id="play-area">
        <div class="hand"></div>
        <div class="play"></div>
        <div style="clear: both"></div>
        
        <img id="deck-nob" src="_cards/up/thumbs/cardback.jpg" />
        <div id="deck-widget">
            <div id="deck-slide"></div>
        </div>                   
    </div>
</div>
<div style="clear: both"></div>
<div id="chat">
    <ul id="chat-messages"></ul>
    <div>
        <div style="float:left; width: 34%;">
            Show:
            <input type="radio" name="filter" id="fshow-all" onchange="filterChatMessages(this);" /> All ::
            <input type="radio" name="filter" id="fshow-user"onchange="filterChatMessages(this);" /> User ::
            <input type="radio" name="filter" id="fshow-system" onchange="filterChatMessages(this);" /> System         
        </div>
        <div style="float:left; width: 65%;">
            <p>
                <input type="text" class="text" id="writemessage" />
                <button type="button" onclick="sendMessage('<?php echo $this->createURL('game/sendgamemessage', array('id' => $gameId)); ?>');" id="sendbtn">Send</button>
            </p>
        </div>
        <div style="clear: both"></div>
    </div>
</div>
<div style="clear: both"></div>

<!-- <div style="display: none">
    <div id="wait-modal">
        Please wait.
    </div>
</div> -->