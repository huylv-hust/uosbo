<?php

class Model_Personfile extends \Orm\Model
{
	protected static $_table_name = 'personfile';
	protected static $_primary_key = array('person_id');
	public function get_data_detail($person_id)
	{
		$data = array();
		$img = \Constants::$_personfile;
		foreach ($img as $key => $value)
		{
			$query = DB::query('SELECT * FROM personfile WHERE person_id ='.$person_id.' AND attr_id ='.$key);
			$data[$key] = $query->execute()->as_array();

		}

		return $data;
	}

	public function delete_data($person_id)
	{
		return DB::delete(self::$_table_name)->where('person_id', $person_id) ->execute();
	}

	public function exists_img($person_id,$attr_id){
		$query = DB::query('SELECT * FROM personfile WHERE person_id ='.$person_id.' AND attr_id ='.$attr_id);

		$data = $query->execute()->as_array();
		return count($data);
	}

	public function update_img($person_id,$attr_id,$datas){

		$query =  DB::query("UPDATE personfile
				  SET content ='".$datas['content']."'
				  WHERE person_id='".$person_id."' AND attr_id='".$attr_id."'");
		$data = $query->execute();
		return $data;

	}

}