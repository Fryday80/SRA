<?php

class DataAccessObject
{
	protected $dataType;
	protected $tableName;
	protected static $dbLink;

	static function init() {
		if (DATA_MOCKING) return;
		self::$dbLink = mysqli_connect(
			MYSQL_HOST,
			MYSQL_BENUTZER,
			MYSQL_KENNWORT,
			MYSQL_DATENBANK, MYSQL_PORT
		);
		mysqli_set_charset(self::$dbLink, 'utf8');

		if (!self::$dbLink) {
			die('keine Verbindung zur Zeit m&ouml;glich - sp&auml;ter probieren ');
		}
	}

	protected function where($valueName, $value) {
		return $this->getBySqlQuery("SELECT * FROM `" . $this->tableName . "` WHERE `" . $valueName . "` = '" . $value . "'");
	}

	protected function updateWhere($column, $columnValue) {
		$setList = "";
		//@todo genderate set list in form "lastname='Doe',pw='pass'"
		if (!mysqli_query($this::$dbLink, "UPDATE MyGuests SET ".$setList." WHERE '" . $column . "'='" . $columnValue . "'")) {
			echo "Error updating record: " . mysqli_error($this::$dbLink);
		}
	}
	function join ($onTable, $srcColumnName, $targetColumnName, $compareValue) {
		$sql = "SELECT $this->tableName.*, $onTable.*".
		"FROM $this->tableName".
		"INNER JOIN $onTable".
		"ON $this->tableName.$srcColumnName=$onTable.$targetColumnName".
		"WHERE $this->tableName.$srcColumnName = $onTable.$compareValue";
		$db_erg = mysqli_query($this::dbLink, $sql);
		if (! $db_erg) {
			echo "Error read record: " . mysqli_error($this::$dbLink);
			return false;
		}
		return $db_erg;
	}
		function save($data) {
			if (is_array($data)) {
				//
			} else if (get_class($data) == $this->dataType) {
				//@todo push to db
				foreach ($data as $key => $value) {
					//build SQL query
					//SET
				}
			}
		}
		private function getBySqlQuery($mysqlQuery) {
			$db_erg = mysqli_query($this::dbLink, $mysqlQuery);
		$i = 0;
		$result = array();
		while ($data = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
			$dataClass = new $this->dataType($this, $data["id"]);
			$result[$i] = $dataClass;
			foreach ($data as $key => $v) {
				if ($key === "id") continue;
				$dataClass[$key] = $v;
			}
			$i++;
		}
		return $result;
	}
}

class ValueObject {
	private $signed = false;
	private $id;
	private $dao;

	function __construct($dao, $id = null) {
		$this->dao = $dao;
		$this->sign($id);
	}
	function getID() {
		return $this->id;
	}
	function setID($id) {
		if ($this->signed) return;
		$this->id = $id;
	}
	function save() {
		if ($this->signed || isset($dao)) {
			$this->dao->save($this);
		}
	}
	protected function sign($id) {
		if ($this->signed) return;
		if ($id !== null) {
			$this->id = $id;
			$this->signed = true;
		}
	}
}