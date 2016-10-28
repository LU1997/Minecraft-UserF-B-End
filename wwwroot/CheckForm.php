<?php

/**
 * Created by PhpStorm.
 * User: sam
 * Date: 2016/10/28
 * Time: 10:53
 */
class LoginCheckForm
{
    protected $name;
    protected $password;
    protected $email;
    protected $postinfo;

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function __construct($name,$password,$email,$postInfo){        //构造方法用于传入所需要的信息。
        $name = htmlspecialchars($this->test_input($name));
        $password = htmlspecialchars($this->test_input($password));
        $email = htmlspecialchars($this->test_input($email));
        $this->name = $name;
        $this->password = $password;
        $this->email = $email;
        $this->postinfo = $postInfo;
    }

    protected function checkName(){                                           //用于检查用户名
        if(empty($name) == 0 || preg_match('/^\w+$/',$this->name)){
            return false;
        }
        else {
            return true;
        }
    }
    protected function checkPassword() {
        if(empty($password) == 0){
            return false;
        }
        else {
            return true;
        }
    }
    protected function checkEmail()
    {
        if (empty($email) == 0 || preg_match('/^([a-z0-9_\.-]+)@([\da-z\.-]+)\.([a-z\.]{2,6})$/', $this->email)) {
            return false;
        } else {
            return true;
        }
    }

    public function checkunity() {
        if(!($this->checkName()) || !($this->checkPassword()) || !($this->checkEmail())){        //
            echo"<script>alert('form_error!');history.go(-1);</script>";                                          //   返回其调用页面  
        }
        else{
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://localhost/public/login.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postinfo);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        }
    }
}

$checkform = new LoginCheckForm($_POST['username'],$_POST['password'],$_POST['emailAdd'],$_POST);
$checkform->checkunity();