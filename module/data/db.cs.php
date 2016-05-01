<?php
class db{
	public $db_link, $db_erg;
	
	public function __construct($db_link){
		$this->db_erg = array();
		$this->db_link = $db_link;
	}
}