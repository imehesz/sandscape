<?php
/*
 * update.php
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
?><?php
$this->breadcrumbs=array(
	'Decks'=>array('index'),
	$model->deckId=>array('view','id'=>$model->deckId),
	'Update',
);

$this->menu=array(
	array('label'=>'List Deck', 'url'=>array('index')),
	array('label'=>'Create Deck', 'url'=>array('create')),
	array('label'=>'View Deck', 'url'=>array('view', 'id'=>$model->deckId)),
	array('label'=>'Manage Deck', 'url'=>array('admin')),
);
?>

<h1>Update Deck <?php echo $model->deckId; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>