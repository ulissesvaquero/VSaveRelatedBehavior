<?php
/**
 * VSaveRelated
 * Vaquero`s Save Related
 * @author Ulisses Vaquero
 * @version 1.0
 * 
 */


class VSaveRelatedBehavior extends CActiveRecordBehavior
{
	
	public static $CBT = 'CBELONGSTORELATION';
	
	public static $CMM = 'CMANYMANYRELATION';
	
	public static $CHM = 'CHASMANYRELATION';
	
	public $result = true;
	
	public $saved = false;
	
	
	public function afterFind($event)
	{
		foreach($this->owner->tableSchema->columns as $column)
		{
			if($column->dbType == 'date' || $column->dbType == 'datetime')
			{
				$this->owner->{$column->name} = date('d/m/Y',strtotime(str_replace("-", "", $this->owner->{$column->name})));
			}
		}
		return true;
	}
	
	public function beforeSave($event)
	{
		foreach($this->owner->tableSchema->columns as $column)
		{
			if($column->dbType == 'date' || $column->dbType == 'datetime')
			{
				$this->owner->{$column->name} = date('Y-m-d',strtotime(str_replace(",", "", $this->owner->{$column->name})));
			}
		}
		return true;		
	}
	
	/*
	 * 
	 */
	private function _validateRelationAttributeValue($varRelationName,$activeRelation,$relationType)
	{
		$valueVarRelationName = $this->owner->$varRelationName;
		switch ($relationType)
		{
			case self::$CBT:
				//If the value of relationVar is object				
				if(is_object($valueVarRelationName) && get_class($valueVarRelationName) == $activeRelation->className)
				{
						$id = $this->vPGPKObj($valueVarRelationName,$activeRelation->className);
						$this->owner->{$activeRelation->foreignKey} = $id;
				}elseif(is_int((int)$valueVarRelationName))
				{
					$id = $this->vByPk($valueVarRelationName,$activeRelation->className);
					//Set in owner class, value of relation pk.
					$this->owner->{$activeRelation->foreignKey} = $id;
				}elseif(empty($valueVarRelationName))
				{
					throw new CException('Value'.get_class($this->owner).'.'.$varRelationName.' is empty');
				}else
				{
					throw new CException('Unexpected value of '.get_class($this->owner).'.'.$varRelationName);
				}
			break;
			
			
			
			case self::$CMM:
				$this->saveModel();
				if(!empty($valueVarRelationName))
				{
					if(preg_match('/^(.+)\((.+)\s*,\s*(.+)\)$/s', $activeRelation->foreignKey, $pieces))
					{
						$arrId = $this->persistChildren($valueVarRelationName, $activeRelation->className);
						//Clean data.
						Yii::app()->db->createCommand()->delete($pieces[1],"$pieces[2] = {$this->owner->getPrimaryKey()}");
						$r = Yii::app()->db->createCommand()->delete($pieces[1],"$pieces[2] = 117");
						foreach($arrId as $id)
						{
							$this->result = Yii::app()->db->createCommand()->insert($pieces[1], array($pieces[2] => $this->owner->getPrimaryKey() , $pieces[3] => $id));
						}
					}else 
					{
						throw new CException("Unable to get table and foreign key information from MANY_MANY relation definition (".$activeRelation->foreignKey.")");	
					}
				}
			break;
			
			
			case self::$CHM:
				$this->saveModel();
				if(!empty($valueVarRelationName))
				{
					$obj = new $activeRelation->className;
					$tableName = $obj->tableName();
					//Clean data.
					Yii::app()->db->createCommand()->delete($tableName,"{$activeRelation->foreignKey} = {$this->owner->getPrimaryKey()}");
					$foreignKeyAttrName = $activeRelation->foreignKey;
					if(is_array($valueVarRelationName))
					{
						foreach($valueVarRelationName as $obj)
						{
							if(get_class($obj) !== $activeRelation->className)
							{
								throw new CException("Unexpected value of ".get_class($this->owner).".".$varRelationName);
							}
							$obj->{$foreignKeyAttrName} = $this->owner->getPrimaryKey();
							$this->vPGPKObj($obj, $activeRelation->className);
						}
					}elseif(is_object($valueVarRelationName))
					{
						$obj->{$foreignKeyAttrName} = $this->owner->getPrimaryKey();
						
					}else 
					{
						throw new CException("Unexpected value of ".get_class($this->owner).".".$varRelationName);
					}
				}
			break;
		}
	}
	
	/**
	 * 
	 * Save owner model.
	 * @throws CException
	 */
	private function saveModel()
	{
		if(!$this->saved)
		{
			if($this->owner->validate())
			{
				$this->owner->save();
				$this->saved = true;
			}else 
			{
				throw new CException("Object ".get_class($this->owner)." is not valid!");
			}
		}
		
	}
	
	/**
	 * 
	 * Validate,Persist,GetPK of an Object.
	 * @param object $obj
	 * @param string $className
	 */
	private function vPGPKObj($obj,$className)
	{
		if(get_class($obj) !== $className)
		{
			throw new CException("Unexpected type of class.");
		}
		if($obj->isNewRecord)
		{
			if($obj->validate())
			{
					$this->result = $obj->save();
					return $obj->getPrimaryKey();
			}else 
			{
				throw new CException("Object is not valid");
			}
		}else 
		{
			return $obj->getPrimaryKey();
		}
	}
	
	/**
	 * 
	 * Get by PK data
	 * @param int $id Id informed by user.
	 * @param string $className Name of expected class.
	 */
	private function vByPk($id,$className)
	{
		$obj = new $className;
		if(!$obj->findByPk($id))
		{
			throw new Exception("Data not found by PK");
		}else
		{
			return $id;
		}
	}
	
	/**
	 * 
	 * Persist childrens.
	 * @param array | object | int $value Value informed by user.
	 * @param string $className className of expected Class
	 */
	private function persistChildren($value,$className)
	{
		$arrId = array();
		if(is_array($value))
		{
			foreach ($value as $v)
			{
				if(is_object($v))
				{
					$arrId[] = $this->vPGPKObj($v,$className);
				}elseif(is_int((int)$v))
				{
					$arrId[] = $this->vByPk($v, $className);
				}
			}
		}else
		{
			if(is_object($value))
			{
				$arrId[] = $this->vPGPKObj($value,$className);
			}elseif(is_int((int)$value))
			{
				$arrId[] = $this->vByPk($value, $className);
			}
		}
		return $arrId;
	}
	
	
	
	/**
	 * Saves the model and/or specified relations
	 * @param mixed $relations the relations to be saved
	 * @param boolean $saveModel weather to save the model or not
	 * @return boolean weather saving was successful
	 */
	public function saveR()
	{
	    $t = false;
		if (!Yii::app()->db->currentTransaction) { // only start transaction if none is running already
		    $t = Yii::app()->db->beginTransaction();
		}
		
		/*
		 * Belongs to relation first
		 */
		$owner = $this->owner;
		
		$arrBelongsToRelation = array();
		$arrRelation = array();
		foreach ($this->owner->relations() as $key => $relation)
		{
			if(strtoupper($relation[0]) === self::$CBT)
			{
				$arrBelongsToRelation[$key] = $relation;
			}else
			{
				$arrRelation[$key] = $relation;
			}
		}
		
		$arrRelation = array_merge($arrBelongsToRelation,$arrRelation);
		
		foreach($arrRelation as $varRelationName => $relation)
		{
			$activeRelation = $owner->getActiveRelation($varRelationName);
			switch (strtoupper(get_class($activeRelation)))
			{
				//CBelongsToRelation
				case self::$CBT:
					//Validate value of attribute, expected values INT OR OBJECT
					$this->_validateRelationAttributeValue($varRelationName,$activeRelation,self::$CBT);
				break;
				
				//CManyManyRelation
				case self::$CMM:
					$this->_validateRelationAttributeValue($varRelationName,$activeRelation,self::$CMM);
				break;
				
				//CHasManyRelation
				case self::$CHM:
					$this->_validateRelationAttributeValue($varRelationName,$activeRelation,self::$CHM);
				break;
			}
		}			
			
        if ($t && $this->result) {
            $t->commit(); // commit 
        }
		if ($t && !$this->result) {
		    $t->rollback(); // rollback 
		}
		
		return $this->result;
	}
}