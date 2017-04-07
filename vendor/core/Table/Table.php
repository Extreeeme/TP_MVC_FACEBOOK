<?php
namespace Core\Table;
use Core\Database\Database;

class Table
{
	protected $db;
	protected $table;
	
	public function __construct(Database $db){

		$this->db = $db;
		if(is_null($this->table)){
		$parts = explode('\\', get_class($this));
		$class_name = end($parts);
		$this->table = strtolower(str_replace('Table', '', $class_name)).'s';
		}
	}

	public function all(){
		return $this->query("
							SELECT * 
							FROM ".$this->table."
							");
	}

	public function query($statement, $attributes = null, $one=false)
	{
		if ($attributes) {
			return $this->db->prepare(
				$statement,
				$attributes,
				str_replace('Table', 'Entity', get_class($this)),
				$one);
		}else{
			return $this->db->query(
				$statement,
				str_replace('Table', 'Entity', get_class($this)),
				$one);
		}
	}

	public function find($id)
	{
		return $this->query("SELECT * FROM {$this->table} WHERE id = ?", [$id], true);
	}

	public function delete($id)
	{
		return $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id], true);
	}

	public function update($id, $fields)
	{
		$sql_parts=[];
		$attributes=[];
		foreach ($fields as $key => $value) {
			$sql_parts[]= "$key = ?";
			$attributes[]= $value;

		}
		$attributes[]= $id;
		$sql = implode(', ', $sql_parts);
		return $this->query("UPDATE {$this->table} SET $sql WHERE id = ?", $attributes);

	}	
	public function create($fields)
	{
		$sql_parts=[];
		$attributes=[];
		foreach ($fields as $key => $value) {
			$sql_parts[]= "$key = ?";
			$attributes[]= $value;

		}
		$sql = implode(', ', $sql_parts);
		return $this->query("INSERT INTO {$this->table} SET $sql", $attributes);

	}


}