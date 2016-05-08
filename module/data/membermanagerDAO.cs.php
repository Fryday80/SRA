<?php
class MemberManagerDAO extends DataAccessObject {
    protected $dataType = "ManagerVO";
    protected $tableName = "login";
    private $dummy;

    function __construct() {
        //create dummy data
        $this->dummy = array(new $this->dataType(1, 1, 1, "peter", "202cb962ac59075b964b07152d234b70", 3, NULL, NULL, NULL),
            new $this->dataType(2, 2,2,  "sepp", "202cb962ac59075b964b07152d234b70", 1, NULL, NULL, NULL));
    }

    public function backend_fetch_by_UserID($selectortable, $all_tables){
        if (DATA_MOCKING) {
            return $this->dummy[0];
        } else {
            $data = $this->wholeMemberDB($selectortable, $all_tables, "usr_id");
            if (count($data) < 1) {
                return false;
            }
            return $data;
        }
    }
}

class ManagerVO extends ValueObject {
    public $usr_id, $login, $pw, $role, $last_change, $since, $last_login;

    function __construct($dao,  $id, $usr_id=NULL, $login=NULL, $pw=NULL, $role=NULL, $last_change=NULL,
                         $since=NULL, $last_login=NULL ) {
        parent::__construct($dao, $id);
        $this->usr_id = $usr_id;
        $this->login = $login;
        $this->pw = $pw;
        $this->role = $role;
        $this->last_change = $last_change;
        $this->since = $since;
        $this->last_login = $last_login;
    }
}
