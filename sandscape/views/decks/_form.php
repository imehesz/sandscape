<?php
$form = $this->beginWidget('CActiveForm', array('id' => 'deck-form'));

$total = 0;
$items = array();
foreach ($deck->deckCards as $dc) {
    if (!isset($items[$dc->cardId])) {
        $items[$dc->cardId]['name'] = $dc->card->name;
        $items[$dc->cardId]['count'] = 1;
    } else {
        $items[$dc->cardId]['count'] += 1;
    }
    $total += 1;
}
?>
<fieldset>
    <legend>Deck information</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($deck, 'name'),
        $form->textField($deck, 'name', array('maxlength' => 100, 'class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($deck, 'name'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($deck->isNewRecord ? 'Create' : 'Save', array('class' => 'button'));

    if (!$deck->isNewRecord && Yii::app()->user->class) {
        CHtml::link('Make Template', $this->createURL('deck/maketemplate', array('id' => $deck->deckId)));
    }

    echo CHtml::link('Cancel', $this->createURL('/decks'));
    ?>
</div>

<div id="hiddenIds">
    <?php
    $i = 0;
    foreach ($items as $key => $item) {
        for ($i = 0; $i < $item['count']; $i++) {
            ?>
            <input type="hidden" name="selected[]" value="<?php echo $key; ?>" id="<?php echo 'h', $key, '-', $i; ?>"/>
            <?php
        }
    }
    ?>
</div>

<?php $this->endWidget(); ?>


<h3>Cards in Deck</h3>
<input type="text" class="textsmaller" id="filterSelected" placeholder="filter cards in deck..." />
<ul id="selected-cards">
    <?php foreach ($items as $key => $item) { ?>
        <li id="s<?php echo $key; ?>" class="in-deck">
            <img src="_resources/images/icon-x16-small-cross.png" />
            <span class="card-name"><?php echo $item['name']; ?></span>
            <span class="card-count"><?php echo $item['count']; ?></span>
        </li>
    <?php } ?>
</ul>
<p>Total cards in deck: <span id="card-total"><?php echo $total; ?></span></p>



<h3>Available Cards</h3>
<input type="text" class="textsmaller" id="filterAvailable" placeholder="filter available cards..." />
<ul id="available-cards">
    <?php foreach ($cards as $card) { ?>
        <li class="available" id="a<?php echo $card->cardId; ?>"><?php echo $card->name; ?></li>
    <?php } ?>
</ul>

<h3>Preview</h3>
<!-- //TODO: remove the fixed width -->
<img src="_game/cards/cardback.jpg" width="250px" id="previewImage" />
