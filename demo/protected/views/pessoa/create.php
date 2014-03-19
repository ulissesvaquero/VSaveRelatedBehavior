<?php
/* @var $this PessoaController */
/* @var $model Pessoa */

$this->breadcrumbs=array(
	'Pessoas'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Pessoa', 'url'=>array('index')),
	array('label'=>'Manage Pessoa', 'url'=>array('admin')),
);
?>

<h1>Create Pessoa</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'corCabelo' => $corCabelo,
			'filho' => $filho,
			'qualidade' => $qualidade)); ?>