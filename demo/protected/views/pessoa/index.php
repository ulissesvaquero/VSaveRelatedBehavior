<?php
/* @var $this PessoaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pessoas',
);

$this->menu=array(
	array('label'=>'Create Pessoa', 'url'=>array('create')),
	array('label'=>'Manage Pessoa', 'url'=>array('admin')),
);
?>

<h1>Pessoas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
