<?php

/** @var CardsController $this */
$this->title = Yii::t('interface', 'Edit Card');

echo $this->renderPartial('_form', array('card' => $card));
