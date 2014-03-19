<?php
/* @var $this PessoaController */
/* @var $model Pessoa */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pessoa-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'idade'); ?>
		<?php echo $form->textField($model,'idade'); ?>
		<?php echo $form->error($model,'idade'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($corCabelo,'id'); ?>
		<?php echo $form->dropDownList($corCabelo,'id',CHtml::listData(CorCabelo::model()->findAll(), 'id', 'cor_cabelo'));?>
		<?php echo $form->error($corCabelo,'id'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($qualidade,'id'); ?>
		<?php echo $form->checkBoxList($qualidade,'id',CHtml::listData(Qualidade::model()->findAll(), 'id', 'qualidade'));?>
		<?php echo $form->error($qualidade,'id'); ?>
	</div>
	
	<div id="filho" class="filho">
		<?php $this->widget('ext.dynamicForm.DynamicForm', array('model' => $filho , 'attribute' => 'nome', 'id' => 'filho','limite' => 5,'ifDDD' => false));?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->