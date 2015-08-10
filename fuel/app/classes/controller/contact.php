<?php

class Controller_Contact extends Controller_Restbase
{
    public function post_send() {
        try {
            if(!isset($_POST['name']) ||
               !isset($_POST['email']) ||
               !isset($_POST['subject'])||
               !isset($_POST['message'])) {
                throw new Exception();
            }

            $message = $_POST['name']."\n".$_POST['email']."\n==========\n".$_POST['subject'].(($_POST['services']!='')?"\n".$_POST['services']:"")."\n\n".$_POST['message'];

            $ret = mb_send_mail('kmutoh@gmail.com','オフィスORAサイトから問い合わせ',$message,'From: noreply@office-ora.com');
            if(!$ret) {
                throw new Exception();
            }

            $this->response(array(
                'result' => true,
            ));
        } catch(Exception $e) {
            $this->response(array(
                'result' => false,
            ));
        }
    }
}
