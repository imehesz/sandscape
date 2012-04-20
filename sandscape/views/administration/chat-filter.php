<?php Yii::app()->clientScript->registerCssFile('_resources/css/sandscape/forms' . (YII_DEBUG ? '' : '.min') . '.css'); ?>

<h2>Chat Filter</h2>

<?php echo CHtml::form($this->createURL('administration/chatfilter')); ?>
<fieldset>
    <legend>List of Banned Words</legend>
    <p>
        You can configure words to be filtered in chat messages. Separate each word 
        by a comma [ , ].
    </p>

    <div class="formrow">
        <?php echo CHtml::textArea('wfilter', $words, array('class' => 'large')); ?>
    </div>
</fieldset>

<div class="buttonrow">
    <?php echo CHtml::submitButton('Save', array('class' => 'button')); ?>
</div>
<?php
echo Chtml::endForm();