<?php
	function admin_check()
	{
		return $_SESSION[admin] != null;
	}

    function crypt_password($password)
    {
        include_once("config.php");
        return sha1($password . $config[salt]);
    }
?>
