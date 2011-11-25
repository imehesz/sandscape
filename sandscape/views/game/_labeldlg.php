<div id="label-dlg">
    <h2>Edit Card Label</h2>
    <p>
        <?php
        echo CHtml::label('Text', 'label-text'), '&nbsp;&nbsp;&nbsp;',
        CHtml::textField('label-text', '', array('class' => 'text', 'size' => 20));
        ?>
    </p>
    <p>
        <?php
        echo CHtml::button('Save', array(
            'onclick' => 'setLabel();',
            'class' => 'simplemodal-close button')), '&nbsp;&nbsp;&nbsp;&nbsp;',
        CHtml::link('Cancel', 'javascript:;', array('class' => 'simplemodal-close'));
        ?>
    </p>
    <input type="hidden" id="label-card-id" />
</div>