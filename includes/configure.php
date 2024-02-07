<?php
  define('HTTP_SERVER', 'http://127.0.0.1/'); // eg, http://localhost - should not be empty for productive servers
  define('HTTPS_SERVER', 'http://127.0.0.1/'); // eg, https://localhost - should not be empty for productive servers
  define('ENABLE_SSL', false); // secure webserver for checkout procedure?
define('ROOT_FOLDER', 'falcon/');
if(ENABLE_SSL===true){
define('FULL_PATH', HTTPS_SERVER.ROOT_FOLDER);	
}else{
	define('FULL_PATH', HTTP_SERVER.ROOT_FOLDER);
}
  define('DIR_INCLUDES', 'includes/');
  define('DIR_VENDORS', 'vendors/');
  define('DIR_FUNCTIONS', DIR_INCLUDES . 'functions/');
  define('DIR_CLASSES', DIR_INCLUDES . 'classes/');
  define('DIR_MODULES', DIR_INCLUDES . 'modules/');

  define('DIR_FS_CATALOG', 'c:/wamp64/www/falcon');


// define our database connection
  define('DB_SERVER', 'localhost'); // eg, localhost - should not be empty for productive servers
  define('DB_SERVER_USERNAME', 'root');
  define('DB_SERVER_PASSWORD', '');
  define('DB_DATABASE', 'falcon');
  define('USE_PCONNECT', 'true'); // use persistent connections?
  define('STORE_SESSIONS', 'mysql'); // leave empty '' for default handler or set to 'mysql'