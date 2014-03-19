<?php
/* @var $this PessoaController */
/* @var $data Pessoa */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('idade')); ?>:</b>
	<?php echo CHtml::encode($data->idade); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_cor_cabelo')); ?>:</b>
	<?php echo CHtml::encode($data->id_cor_cabelo); ?>
	<br />


</div>