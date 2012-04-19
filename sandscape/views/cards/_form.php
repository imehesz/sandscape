<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'card-form',
    'enableAjaxValidation' => true,
    'htmlOptions' => array('enctype' => 'multipart/form-data')
        ));
?>

<fieldset>
    <legend>Card Info</legend>
    <div class="formrow">
        <?php
        echo $form->labelEx($card, 'name'),
        $form->textField($card, 'name', array('maxlength' => 150, 'class' => 'text'));
        ?>
    </div>

    <?php echo $form->error($card, 'name'); ?>
    <div class="formrow">
        <?php
        echo $form->labelEx($card, 'cardscapeId'),
        $form->textField($card, 'cardscapeId', array('class' => 'text'));
        ?>
    </div>
    <?php echo $form->error($card, 'cardscapeId'); ?>

    <div class="formrow">
        <?php
        echo $form->labelEx($card, 'rules'),
        $form->textArea($card, 'rules', array('rows' => 4, 'cols' => 50));
        ?>
    </div>
    <?php echo $form->error($card, 'rules'); ?>
</fieldset>

<fieldset>
    <legend>Card Image</legend>
    <div class="formrow">
        <?php
        if (!$card->isNewRecord) {
            echo CHtml::image('_game/cards/' . $card->image);
        }
        ?>
        <?php echo $form->fileField($card, 'image'); ?>
    </div>
    <?php echo $form->error($card, 'image'); ?>
</fieldset>

<div class="buttonrow">
    <?php
    echo CHtml::submitButton($card->isNewRecord ? 'Create' : 'Save', array('class' => 'button')),
    CHtml::link('Cancel', $this->createUrl('/cards'));
    ?>
</div>

<?php
$this->endWidget();