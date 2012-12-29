<?php $this->title = 'Game Tokens'; ?>
<h2>Game Tokens</h2>

<div class="list-tools">
    <a href="<?php echo $this->createURL('create'); ?>">Create Token</a>
</div>

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'token-grid',
    'dataProvider' => $filter->search(),
    'filter' => $filter,
    'cssFile' => false,
    'columns' => array(
        array(
            'name' => 'name',
            'type' => 'html',
            'value' => 'CHtml::link($data->name, Yii::app()->createUrl("tokens/update", array("id" => $data->tokenId)))'
        ),
        array(
            'header' => 'Actions',
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array('visible' => 'false')
            )
        )
    ),
    'template' => '{items} {pager} {summary}'
));