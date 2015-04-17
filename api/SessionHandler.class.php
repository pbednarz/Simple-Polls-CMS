<?php

final class SessionHander
{
    /**
     * @var object
     * @access private
     */
    private static $oInstance = false;

    /**
     * @return SessionHander
     * @access public
     * @static
     */
    public static function getInstance()
    {
        if( self::$oInstance == false )
        {
            self::$oInstance = new SessionHander();
        }
        return self::$oInstance;
    }

    private function __construct() {}

    public static function getSession(){
        if (!isset($_SESSION)) {
            session_start();
        }
        $sess = array();
        if(isset($_SESSION['uid']))
        {
            $sess["uid"] = $_SESSION['uid'];
            $sess["username"] = $_SESSION['username'];
            $sess["email"] = $_SESSION['email'];
        }
        else
        {
            $sess["uid"] = '';
            $sess["username"] = 'Guest';
            $sess["email"] = '';
        }
        return $sess;
    }

    public function destroySession(){
        if (!isset($_SESSION)) {
            session_start();
        }
        if(isSet($_SESSION['uid']))
        {
            unset($_SESSION['uid']);
            unset($_SESSION['username']);
            unset($_SESSION['email']);
            $info='info';
            if(isSet($_COOKIE[$info]))
            {
                setcookie ($info, '', time() - $cookie_time);
            }
            $msg="Logged Out Successfully...";
        }
        else
        {
            $msg = "Not logged in...";
        }
        return $msg;
    }
}
?>
