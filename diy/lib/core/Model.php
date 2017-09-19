<?php
namespace core;
use common\config\Config;
class Model {
	private $host;
	private $port;
	private $user;
	private $password;
	private $db;
	private $error;
	static $intance;

	public function __construct () {
		require_once BASE_ROOT.'common/config/config.php';
		if(self::$intance) {
			return self::$intance;
		}
		$mysql = Config::$mysql;
		if(empty($mysql)) {
			$this->error = $mysql;
			return false;
		}
		$this->host = empty($mysql['host']) ? '' : $mysql['host'];
		$this->port = empty($mysql['port']) ? '' : $mysql['port'];
		$this->user = empty($mysql['user']) ? '' : $mysql['user'];
		$this->password = empty($mysql['password']) ? '' : $mysql['password'];
		$this->db = empty($mysql['db']) ? '' : $mysql['db'];

		try{
			self::$intance = new \PDO("mysql:dbname={$this->db};host={$this->host}",$this->user,$this->password);
		}catch(PDOException $e) {
			$this->error = "Connect Error(".$e->getMessage().")";
		}

	}

	public function query ($sql) {
		$res = self::$intance->query($sql);
		return $res->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getOne ($sql) {
		$res = self::$intance->query($sql);
		return $res->fetch(\PDO::FETCH_ASSOC);
	}

	public function getAll ($sql) {
		$res = self::$intance->query($sql);
		return $res->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function getNum ($sql) {
		$res = self::$intance->query($sql);
		return $res->rowCount();
	}

	public function update ($datas,$where,$table) {
		$sql = "update {$table} set ";
		if(empty($datas)) return false;
		foreach($datas as $key => $val) {
			$sql .= "`{$key} = `'{$val}'";
		}
		$sql .= 'where '.$where.';';
		return $this->getNum($sql);
	}

	public function insert ($datas,$table) {
		if(empty($datas)) return false;
		$keys = array_keys($datas);
		$keys_str = join(',',$keys);
		$sql = "insert into {$table} ({$keys_str}) values(";
		foreach($datas as $key => $val) {
			$sql .= "'{$val}',";
		}
		$sql = substr($sql,0,-1).');';
		return $this->getNum($sql);
	}

	public function delete ($table,$id) {
		$sql = "delete from {$table} where id";
	}

	public function getError () {
		if($this->error) {
			return $this->error;
		}
		return self::$intance->errorInfo();
	}

	public function __destruct () {
		self::$intance = null;
	}

}