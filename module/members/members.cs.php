<?php
class Member_Manager {
    
    
    function __construct()
    {
    }
    
    //@todo member auslesen
    protected function get_members ()
    {
        $backend_userDAO = new UserDAO();
        $backend_userDAO = $backend_userDAO->backend_fetch();
        bugfix_expression('print_r ($backend_userDAO');
        print_r($backend_userDAO);
    }
    //@todo memberliste erstellen
    //@todo kassenliste erstellen bei berechtigung
    
}
