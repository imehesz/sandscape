<?php

/** @var TokensController $this */
$this->title = Yii::t('interface', 'New Token');

echo $this->renderPartial('_form', array('token' => $token));
