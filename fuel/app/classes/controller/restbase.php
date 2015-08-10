<?php
class Controller_Restbase extends Controller_Rest
{
    public function before()
    {
        parent::before();
        if(is_null(Input::post(Config::get("security.csrf_token_key"))) ||
           !Security::check_token())
        {
            header("HTTP/1.0 403 Forbidden");
            exit;
        }
    }

    public function after($response)
    {
        return parent::after($response);
    }
}
?>
