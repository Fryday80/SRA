<?php
class backend_members
{
    function __construct()
    {
       $this->get_members();
    }
    protected function get_members ()
    {
        $userDAO = new UserDAO();
        ;
    }
}
