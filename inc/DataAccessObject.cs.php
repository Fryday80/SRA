<?php

class DataAccessObject
{
	protected $dataType;
	protected $tableName;
	protected static $dbLink;
	protected $all_Member_DB;

	static function initDB() {
		if (DATA_MOCKING) return;
		bugfix (MYSQL_HOST.'<br>');
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

	protected function wholeTable (){
		return $this->getBySqlQuery("SELECT * FROM `" . $this->tableName . "` ");
	}

	protected function run_sql($sql){
		$db_erg = mysqli_query(self::$dbLink, $sql);
		return $db_erg;
	}

	function save($data) {
		if (is_array($data)) {
			$id = $data['id'];
			$sql = "";
			foreach ($data as $key => $value) {
				$sql = $sql." ".$key." = '".$value."',";
			}
			//print($sql);
			$sql = substr($sql, 0, strlen($sql) - 1);
			//remove last ","
			$sql = "UPDATE $this->tableName SET ".$sql." WHERE id = '".$id."'";
			//print($sql);
			$save = $this->run_sql($sql);
		} else if (get_class($data) == $this->dataType) {
			//@todo push to db
			$sql = "";
			foreach ($data as $key => $value) {
				$sql = $sql." ".$key." = '".$value."',";
			}
			print($sql);
			$sql = substr($sql, 0, strlen($sql) - 1);
			//remove last ","
			$sql = "UPDATE $this->tableName SET ".$sql." WHERE id = '".$data->getID()."'";
			//print($sql);
			$save = $this->run_sql($sql);
		}
	}

	function delete($id){
		$sql = "DELETE FROM $this->tableName WHERE `id` = ".$id;
		$delete = $this->run_sql($sql);
	}

	function insert($data){
		if (is_array($data)) {
			$count = count($data);
			$i=1;
			$keys = '';
			$values = '';
			foreach ($data as $key => $value){
				if ($i < $count) {
					$keys = $keys . ' `' . $key . '`,';
					$values = $values . " '" . $value . "',";
					$i++;
				}else{
					$keys = $keys . ' `' . $key.'`';
					$values = $values . " '" . $value."'";
				}
			}
			$sql = "INSERT INTO `$this->tableName` (".$keys.") VALUES (".$values.");";
			bugfix ($sql);
			$db_erg = mysqli_query(self::$dbLink, $sql);
			//$insert = $this->run_sql($sql);
		}
	}

	private function getBySqlQuery($mysqlQuery) {
		$db_erg = mysqli_query(self::$dbLink, $mysqlQuery);
		$i = 0;
		$result = array();
		while ($data = mysqli_fetch_array($db_erg, MYSQLI_ASSOC)) {
			$dataClass = new $this->dataType($this, $data["id"]);
			$result[$i] = $dataClass;
			foreach ($data as $key => $v) {
				if ($key === "id") continue;
				$dataClass->$key = $v;
			}
			$i++;
		}
		return $result;
	}

	/*
        protected function updateWhere($column, $columnValue) {
            $setList = "";
            //@todo genderate set list in form "lastname='Doe',pw='pass'"
            if (!mysqli_query(self::$dbLink, "UPDATE MyGuests SET ".$setList." WHERE '" . $column . "'='" . $columnValue . "'")) {
                echo "Error updating record: " . mysqli_error(self::$dbLink);
            }
        }
        function join ($onTable, $srcColumnName, $targetColumnName, $compareValue) {
            $sql = "SELECT $this->tableName.*, $onTable.*".
                "FROM $this->tableName".
                "INNER JOIN $onTable".
                "ON $this->tableName.$srcColumnName=$onTable.$targetColumnName".
                "WHERE $this->tableName.$srcColumnName = $onTable.$compareValue";
            $db_erg = mysqli_query(self::$dbLink, $sql);
            if (! $db_erg) {
                echo "Error read record: " . mysqli_error(self::$dbLink);
                return false;
            }
            return $db_erg;
        }

            protected function wholeMemberDB ($selectortable, $all_tables, $srcColumnName){
                $this->all_Member_DB = array ($all_tables );
                $sql = $this->joined_tables($selectortable, $this->all_Member_DB, $srcColumnName);
                return $this->getBySqlQuer$sql);
            }

            //@todo mal schauen^^
            /*
            function joined_tables ($selectortable, $all_DB_Tables, $srcColumnName) {
                $count_tables = count ($all_DB_Tables);
                $table_string = '';
                $search_string = '';
                $i = 2;
                foreach ($all_DB_Tables as $item) {
                    print_r($item);
                    foreach ($item as $items) {
                    }
                    if ($items !== $selectortable) {
                        if ($i < $count_tables) {
                            $table_string .= "$items .*, ";
                            $search_string .= "$items.$srcColumnName AND";
                            $i++;
                        } elseif ($i = $count_tables) {
                            $table_string .= $items . '.* ';
                            $search_string .= "$items.$srcColumnName";
                        }
                    }
                }

                $sql = "SELECT * FROM $selectortable ".
                    "INNER JOIN $table_string ".
                    "ON $selectortable.$srcColumnName = $search_string ";
                $db_erg = mysqli_query(self::$dbLink, $sql);
                if (! $db_erg) {
                    echo "Error read record: " . mysqli_error(self::$dbLink);
                    return false;
                }
                return $db_erg;
            }
            */
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
		print_r(($this->signed)?"true": "false" );
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