<?php

abstract class Db_frame {
	/*****
		Purpose:
			Provides fundamental database connection and management methods.
			Intended to be extended with database connection info.

		Extending Requirements:
			Provide the following data members (variables) in any extended classes.
				- $db_host:	Hostname, and port if applicable, of the MySQL database.
				- $db_user:	Username used to connect to the database.
				- $db_pass:	Password used to connect to the database.
				- $db_name: Name of database to connect to.
	*****/

	public $conn;

	function __construct() {
		//	Check if required variables are set.
		if (empty($this->db_host) || empty($this->db_user) || empty($this->db_pass) || empty($this->db_name)) {
			//die("DB CONNECTION ERROR:  Missing database connection info.");
			return;
		}
	}	//	end __construct()

	function connect() {
		/*****
			Purpose:
				To connect to a MySQL database and return the connection object.
			Parameters:
				none
			Returns:
				Object representing connection to MySQL server
			Sample Usage:
				connect();
				connect("localhost", "myuser", "mypass", "myname");
		*****/
		$db = new mysqli($this->db_host, $user = $this->db_user, $this->db_pass, $this->db_name);

		if ($db->connect_error) {
			//die("DB CONNECTION ERROR: Could not connect to database.  (" . $db->connect_error . ")");
			return;
		}

		$this->conn = $db;

		return $db;
	}	//	end connect()

	function runquery($query) {
		/*****
			Purpose:
				To execute a query on a MySQL database
			Parameters:
				$db: Object representing connection to MySQL server
				$query: String containing SQL query to run
			Returns:
				Result object for SELECT, SHOW, DESCRIBE, or EXPLAIN.  Boolean true for other succesful queries.
			Sample Usage:
				connect();
				connect("localhost", "myuser", "mypass", "myname");
		*****/
		$this->connect();

		if ($result = $this->conn->query($query)) {
			return $result;
		}

		//die("DB CONNECTION ERROR: Could not execute query (" . $query . ") on database.  (" . $this->conn->error . ")");

		return;
	}	//	end query()
}	//	end class DB