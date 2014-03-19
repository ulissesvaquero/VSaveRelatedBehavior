<?php

/**
 * This is the model class for table "pessoa".
 *
 * The followings are the available columns in table 'pessoa':
 * @property integer $id
 * @property string $nome
 * @property integer $idade
 * @property integer $id_cor_cabelo
 *
 * The followings are the available model relations:
 * @property Filho[] $filhos
 * @property CorCabelo $idCorCabelo
 * @property Qualidade[] $qualidades
 */
class Pessoa extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'pessoa';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('id_cor_cabelo'),
			array('idade, id_cor_cabelo', 'numerical', 'integerOnly'=>true),
			array('nome', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, idade, id_cor_cabelo', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'filhos' => array(self::HAS_MANY, 'Filho', 'id_pessoa'),
			'idCorCabelo' => array(self::BELONGS_TO, 'CorCabelo', 'id_cor_cabelo'),
			'qualidades' => array(self::MANY_MANY, 'Qualidade', 'qualidade_pessoa(id_pessoa, id_qualidade)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'idade' => 'Idade',
			'id_cor_cabelo' => 'Id Cor Cabelo',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('idade',$this->idade);
		$criteria->compare('id_cor_cabelo',$this->id_cor_cabelo);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pessoa the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	public function behaviors()
	{
        return array('VSaveRelatedBehavior' => array(
         			 'class' => 'application.extensions.VSaveRelatedBehavior'),
     	);
	}
	
	
}
