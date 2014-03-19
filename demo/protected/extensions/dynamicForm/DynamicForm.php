<?php
/**
 * 
 * Campo que pode ser adicionado dinâmicamente.
 * @author ulissesvaquero
 *
 */
class DynamicForm extends CWidget
{
	//Nome do campo
	public $id;
	//Botao de adicionar
	public $botaoMais = "plus";
	//Botao de remover
	public $botaoMenos = "minus";
	//Variável de limite de campos duplicados
	public $limite;
	//Modelo
	public $model;
	//Atributo do modelo
	public $attribute;
	//Opções Html
	public $htmlOptions=array();
	/*
	 * Variavél de controle de DDD,
	 * responsável por carregar o campo
	 * DDD.
	 */
	public $ifDDD = false;
	
	public $content = "";
	
	public function init()
	{
		$assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
		
		$cls = Yii::app()->getClientScript();
		$cls->registerScriptFile($assets . '/js/jquery-dynamic-form.js');
		
		$js = "jQuery('#{$this->id}').dynamicForm(\"#{$this->botaoMais}\",\"#{$this->botaoMenos}\",{limit:{$this->limite}});";		
		
		$cls->registerScript(__CLASS__ . '#' . $this->id, $js);
		
		$this->content = CHtml::activeLabel($this->model,$this->attribute); 
		
		if($this->ifDDD)
		{
			$this->content .= CHtml::textField($this->attribute.'_ddd','',array('size' => 2,'maxlength' => 2)).
			CHtml::textField($this->attribute, '');
		}else 
		{
			$this->content .= CHtml::textField($this->attribute);	
		}
		echo $this->content."<span><a id=\"minus\" style=\"display: none;\">[-]</a> <a id=\"plus\">[+]</a></span>";
	}
	
}