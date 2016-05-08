<?php
class Member_Manager {
    protected $all_tables = array();
    protected $selectortable;
    public $logindata = array();
    public $memberdata = array();
    public $wappendata = array();
    public $roledata = array();

    function __construct()
    {
        $this->selectortable = "login";
        $this->all_tables = array ("login", "memberdata", "wappenrolle");
    }
    
    //@todo member auslesen
    public function get_All_Data ()
    {
        $array_of_datas = array ("logindata", "memberdata", "wappendata", "roledata");
        $this->logindata = new UserDAO();
        $this->logindata = $this->logindata->get_all_members();
        $this->memberdata = new MembersDAO();
        $this->memberdata = $this->memberdata->get_all_members();
        $this->wappendata = new WappenDAO();
        $this->wappendata = $this->wappendata->getRolle();
        $this->roledata = new RolesDAO();
        $this->roledata = $this->roledata->getRoles();

        $all_data = $this->verwurschteln($array_of_datas);
        return $all_data;
        
        //@todo $kassendaten = new KassenDAO
        
    }

    protected function verwurschteln ($array_of_datas) {
        $i = 0;
        foreach ($array_of_datas as $dataVOs){
            $i = 0;
            $$dataVOs = $this->$dataVOs;
            if ($dataVOs == 'logindata' OR $dataVOs == 'memberdata') {
                foreach ($$dataVOs as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $result[$dataVOs][$i][$key2] = $value2;
                    }
                    $i++;
                }
            }
            if ($dataVOs == 'roledata') {
                bugfix('roledata');
                foreach ($$dataVOs as $key1 => $value1) {
                    foreach ($value1 as $key2 => $value2) {
                        $result[$dataVOs][$i][$key2] = $value2;
                        bugfix ('begin');
                        print_r ($key1);
                        bugfix ('end');
                    }
                    $i++;
                }
            }
        }
        bugfix('bigone');
        print_r ($result);
        return $result;
    }
    //@todo memberliste erstellen
    //@todo kassenliste erstellen bei berechtigung
    
    
    /* old
    $managerDAO = new MemberManagerDAO();
        $managerDAO = $managerDAO->backend_fetch_by_UserID($this->selectortable, $this->all_tables);
        bugfix_expression('print_r ($managerDAO');
        print_r($managerDAO);
    */
    
}
