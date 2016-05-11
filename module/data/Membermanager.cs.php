<?php
class MemberManager {
    protected $member_tables;

    function __construct() {

        $this->member_tables = array(   "login"         => "UserDAO",
                                        "memberdata"    => "MembersDAO",
                                        "wappenrolle"   => "WappenDAO",
                                        "roles"         => "RolesDAO");
    }

    protected function prepare ($tabelle){
        bugfix ('MM_DAO,f__ fetch_DB_array, "$tabelle" '.$this->member_tables[$tabelle], 3);
        $new_DAO = $this->member_tables[$tabelle];
        $result = $this->get_VO($new_DAO);
        return $result;

    }
    protected function get_VO ($used_DAO){
        $new_DAO = new $used_DAO;
        if ($used_DAO == 'RolesDAO'){
            bugfix ('MM_DAO,f__ get_DB_array, "if roles"', 3);
            $new_DAO = $new_DAO->getRoles();}
        elseif ($used_DAO == 'WappenDAO'){
            bugfix ('MM_DAO,f__ get_DB_array, "if wappen"', 3);
            $new_DAO = $new_DAO->getRolle();}
        else {
            bugfix ('MM_DAO,f__ get_DB_array, "else"', 3);
            $new_DAO = $new_DAO->get_all_members();}
        return $new_DAO;
    }

     /**
     * Liste erstellen vom Typ xy
     *
     * @param  $of_kind string
     */
    public function create_list ($of_kind){
        if (in_array($of_kind, $this->member_tables)){
            foreach ($of_kind as $key => $value) {//hier?
                if ($of_kind == $key) {
                    $result[0] = $this->prepare($of_kind);
                }
                if ($of_kind == $value){
                    $result[0] = $this->prepare($key);
                }
            }
        }
        if ($of_kind == 'all'){
            foreach ($this->member_tables as $key => $values){
                $result[$key] = $this->prepare($key);
            }
        }
        return $result;
    }
}
class MemberManager_Views {
    protected $dao;

    function __construct()
    {
        $this->dao = new MemberManager();

    }

    function show_list($of_kind){
        $list = $this->dao->create_list($of_kind);
        

        $count = count($list['login']);
        bugfix ($count,3);
        for ($i=1; $i <= $count; $i++) 
        {
            foreach ($list as $key => $value)
            {
                //d($value);
                echo '<table>'; //hier iterierst du aber über ein array
                echo '<tr><th colspan="3">' . $key . '</th></tr>';
                foreach ($value as $key0) {
                    //d($key0);
                    echo '<tr><th>Bezeichnung</th><th>Beschreibung</th><th>Wert</th></tr>';
                    foreach ($key0 as $key1 => $value1) {
                        d($key0);
                        if ($key1 == ['usr_id'] AND $value1 == $i) {

                            echo '<tr><td>' . $key1 . '</td><td></td><td>';
                            p_textfield('text', $key . '_' . $key1, $value1, '', 1);
                            echo '</td></tr>';
                        }
                    }
                }
                echo '</table>';
            }
        }
        pre_on();
        bugfix ('MM_Views, f__ show_list');
        print_r ($list);
        pre_off();
        echo 'create view from $list here';
    }
}
