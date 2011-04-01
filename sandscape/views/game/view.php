<?php
$this->breadcrumbs=array(
	'Games'=>array('index'),
	$model->gameId,
);

$this->menu=array(
	array('label'=>'List Game', 'url'=>array('index')),
	array('label'=>'Create Game', 'url'=>array('create')),
	array('label'=>'Update Game', 'url'=>array('update', 'id'=>$model->gameId)),
	array('label'=>'Delete Game', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->gameId),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Game', 'url'=>array('admin')),
);
?>

<h1>View Game #<?php echo $model->gameId; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'gameId',
		'playerA',
		'playerB',
		'created',
		'started',
		'ended',
		'running',
		'deckA',
		'deckB',
		'hash',
		'chatId',
		'private',
	),
)); ?>
