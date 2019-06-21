<?php

class Signout extends APP_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->unset_userdata(["IS_LOGGED", "SESSION_ID", "ACCOUNT_TYPE"]);
        delete_cookie("UID");
        redirect("/");
    }
}
