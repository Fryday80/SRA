<?php
class MemberManagerDAO extends DataAccessObject {
    protected $dataType = "ManagerVO";
    protected $member_tables;
    private $dummy;

    function __construct() {
        //create dummy data
        $this->dummy = array(new $this->dataType(1, 1, 1, "peter", "202cb962ac59075b964b07152d234b70", 3, NULL, NULL, NULL),
            new $this->dataType(2, 2,2,  "sepp", "202cb962ac59075b964b07152d234b70", 1, NULL, NULL, NULL));
        //real data
        $this->member_tables = array(   "login" => "UserDAO",
                                        "memberdata" => "MembersDAO",
                                        "wappenrolle" => "WappenDAO",
                                        "roles" => "RolesDAO");
    }

    protected function fetch_DB_array ($tabelle){
        bugfix ('MM_DAO,f__ fetch_DB_array, "$tabelle" '.$this->member_tables[$tabelle], 3);
        $new_DAO = $this->member_tables[$tabelle];
        $result = $this->get_DB_array($new_DAO);
        return $result;

    }
    protected function get_DB_array ($used_DAO){
        $new_DAO = new $used_DAO;
        if ($used_DAO == 'RolesDAO'){bugfix ('MM_DAO,f__ get_DB_array, "if roles"', 3); $new_DAO->getRoles();}
        elseif ($used_DAO == 'WappenDAO'){bugfix ('MM_DAO,f__ get_DB_array, "if wappen"', 3); $new_DAO->getRolle();}
        else {bugfix ('MM_DAO,f__ get_DB_array, "else"', 3); $new_DAO->get_all_members();}
        return $new_DAO;
    }

    protected function cleanup_VOs ($result_VO) {
        foreach ($result_VO as $key => $value){
            foreach ($value as $key1 => $value1) {
                print_r($value);
                print ('#########<br>');
            }
        }
        $cleaned_up = $result_VO;
        bugfix ('MM_DAO,f__ clean_up',3);
        return $cleaned_up;

    }

    /**
     * Liste erstellen vom Typ xy
     *
     * @param  $of_kind string
     */
    public function create_list ($of_kind){
        if (in_array($of_kind, $this->member_tables)){
            foreach ($of_kind as $key => $value) {
                if ($of_kind == $key) {
                    $result[0] = $this->fetch_DB_array($of_kind);
                }
                if ($of_kind == $value){
                    $result[0] = $this->fetch_DB_array($key);
                }
            }
        }
        if ($of_kind == 'all'){
            foreach ($this->member_tables as $key => $values){
                $result[$key] = $this->fetch_DB_array($key);
            }
        }
        $clean_result_array = $this->cleanup_VOs($result);
        return $clean_result_array;
    }
}

class MemberManager_Views {
    protected $dao;

    function __construct()
    {
        $this->dao = new MemberManagerDAO();

    }

    function show_list($of_kind){
        $list = $this->dao->create_list($of_kind);
        foreach ($list as $key => $value){
            foreach ($list[$key] as $key2 => $value2){

            }
        }
        pre_on();
        bugfix ('MM_Views, f__ show_list');
        print_r ($list);
        pre_off();
        echo 'create view from $list here';
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
