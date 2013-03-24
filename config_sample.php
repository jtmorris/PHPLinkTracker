<?php

//	Sample configuration file.  Copy or rename this file to config.php and 
//	fill in the following settings.


require_once("classdef_db.php");

class Db extends Db_frame {

	////////////////////////////////////
	//	Database Connection settings //
	///////////////////////////////////
	
	//	Database hostname.  If you're not sure what this should be, try "localhost".
	protected $db_host = "";

	//	Database username.
	protected $db_user = "";

	//	Database password.
	protected $db_pass = "";

	//	Database name.
	protected $db_name = "";
}
