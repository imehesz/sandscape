<?php
/*
 * _form.php
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
?><div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
                'id' => 'card-form',
                'enableAjaxValidation' => false,
                'htmlOptions' => array('enctype' => 'multipart/form-data')
                    )
    );
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>
    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'name'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'name'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'name'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'faction'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'faction', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'faction'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'type'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'type', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'type'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'subtype'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'subtype', array('size' => 60, 'maxlength' => 150)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'subtype'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'cost'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'cost'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'cost'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'threshold'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'threshold', array('size' => 60, 'maxlength' => 100)); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'threshold'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'attack'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'attack'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'attack'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'defense'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'defense'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'defense'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'rules'); ?></div>
        <div class="rightformcolum"><?php echo $form->textArea($model, 'rules'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'rules'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'revision'); ?></div>
        <div class="rightformcolum"><?php echo $form->textField($model, 'revision'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'revision'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($model, 'private'); ?></div>
        <div class="rightformcolum"><?php echo $form->checkBox($model, 'private'); ?></div>
        <div class="formfielderror"><?php echo $form->error($model, 'private'); ?></div>
    </div>

    <div class="row">
        <div class="leftformcolum"><?php echo $form->labelEx($image, 'filename');  ?></div>
        <div class="rightformcolum"><?php echo CHtml::activeFileField($image, 'file'); ?></div>
        <div class="formfielderror"><?php echo $form->error($image, 'filename'); ?></div>
    </div>


    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->