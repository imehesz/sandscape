<?php

/** @var CardsController $this */
$this->title = Yii::t('sandsacpe', 'Edit Card');

echo $this->renderPartial('_form', array('card' => $card));
<?php
if (YII_DEBUG) {
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/forms.css');
    Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/development/deck.css');
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/css/development/deck.js', CClientScript::POS_HEAD);
}

$url = $this->createUrl('decks/imagepreview');
Yii::app()->clientScript->registerScript('init', "init('{$url}');");

$this->title = ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck');
?>
<h2><?php echo ($deck->isNewRecord ? 'Create Deck' : 'Edit Deck'); ?></h2>   

<?php echo $this->renderPartial('_form', array('deck' => $deck, 'cards' => $cards)); ?>

<p>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'txt')); ?>">
        <img src="_resources/images/icon-x16-document-text.png" title="Export as Text" />
    </a>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'html')); ?>">
        <img src="_resources/images/icon-x16-html.png" title="Export as HTML" />
    </a>
    <a href="<?php echo $this->createUrl('decks/export', array('id' => $deck->deckId, 'type' => 'pdf')); ?>">
        <img src="_resources/images/icon-x16-document-pdf.png" title="Export as PDF" />
    </a>
</p>