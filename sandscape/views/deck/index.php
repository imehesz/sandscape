<div class="span-24">
    <h2>Manage Decks</h2>
    <div class="span-2 prepend-22 last"><a href="<?php echo $this->createURL('create'); ?>">New Deck</a></div>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'deck-grid',
        'dataProvider' => $filter->search(Yii::app()->user->getId()),
        'filter' => $filter,
        'columns' => array(
            'name',
            array(
                'name' => 'created',
                'type' => 'date',
                'value' => 'strtotime($data->created)',
                'filter' => false
            ),
            array(
                'header' => 'Actions',
                'class' => 'CButtonColumn',
                'buttons' => array(
                    'view' => array('visible' => 'false'),
                )
            ),
        ),
    ));
    ?>
</div>
