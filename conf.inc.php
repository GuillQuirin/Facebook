<?php
	define("DBHOST","localhost");
	define("DBUSER","root");
	define("DBPWD","root");
	define("DBNAME","facebook");
    
    define("WEBPATH", str_replace('/index.php', '', $_SERVER['SCRIPT_NAME']));
    define('__ROOT__', dirname(dirname(__FILE__)).WEBPATH);

    define("SALT", "GRErgtgfgfbgbe45DFE");
    define("COOKIE_TOKEN", "breakemallyplrvh");
    define("COOKIE_EMAIL", "breakemallyrùzom");
    define("AUTORISATION", "validationdescookies");

    if($_SERVER['SERVER_NAME'] == 'localhost')
    	if( is_numeric(strpos(WEBPATH, '/EGL')) )
    		define("LOCALPATH", str_replace("\\", "/", getcwd().str_replace('/EGL', '', WEBPATH)) );
            //Remplacer le  1er parametre du second str_replace() par le nom du dossier racine
    	else
    		define("LOCALPATH", str_replace("\\", "/", getcwd().WEBPATH));
    else
    	define("LOCALPATH", "//home/breakem-all/public_html");
