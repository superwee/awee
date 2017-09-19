<?php
namespace model;
use core\Model;
class user extends Model {
	private $table = 'user';

	public function checkUser ($data) {
		if(empty($data)) return false;
		$sql = "select * from {$this->table} where";
		foreach($data as $key => $val) {
			$sql .= " `$key` = '{$val}' and";
		}
		$sql = substr($sql,0,-3).'limit 1;';

		return $this->getNum($sql);
	}

	public function doInsert ($datas) {
		return $this->insert($datas,$this->table);
	}
}