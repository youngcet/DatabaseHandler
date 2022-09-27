<?php
	
	require_once ("Database.php");

	/**
	 * Database Handler
	 *
	 * This class prepares and executes sql queries. 
	 *
	 * @category   MySQL
	 * @package    DatabaseHandler
	 * @author     Cedric Maenetja <cedricm@permanentlink.co.za>
	 * @copyright  2022 Permanent Link CO
	 * @license    Permanent Link CO
	 * @version    Release: 1.0
	 */

	class DatabaseHandler extends Database
	{
		private $_dbconn;
		private $_stmt;
		private $_results;
		private $_error;

		public function __construct()
		{
			$this->_dbconn = $this->connect();
			$this->_stmt = (object) array();
			$this->_error = $this->_results = array();
		}



		/**
		 * Connects to the database
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return database object
		 */ 

		public function isConnected ()
		{
			return $this->_dbconn;
		}
        


		/**
		 * Prepares SQL query
		 *
		 * @param string  	$sqlStatement The SQL Prepared Statement
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return 1 or an App\Custom\Error
		 */ 

		public function prepareStatement ($sqlStatement)
		{
			if (! $this->isConnected() || ! $this->_stmt = $this->_dbconn->prepare ($sqlStatement))
			{
				return new App\Custom\Error (-1, $this->_dbconn->connect_error);
			}

			return 1;
		}



		/**
		 * Executes a SQL query and bind the values
		 *
		 * @param string  	$values The values to pass to the SQL query
		 * @param array 	$valueType 	The binding string
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return @return 1 or an App\Custom\Error
		 */ 

		public function executeStatement ($values, $valueType)
		{
		    if (! empty($values) && ! empty ($valueType)) $this->_stmt->bind_param ($valueType, ...$values);
		
			if (! $this->isConnected() || ! $this->_stmt->execute())
			{
				return new App\Custom\Error (-1, $this->_dbconn->connect_error);
			}

			$this->_results = $this->_stmt->get_result();
			$this->_stmt->close();

			return 1;

		}



		/**
		 * Fetch a single row of data
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return Array
		 */ 

		public function fetchRow()
		{
		    $results = array();
			if ($this->_results->num_rows === 0)
			{
				return $results;
			}
            
			return $this->_results->fetch_assoc();;
		}
		


		/**
		 * Fetch all rows
		 *
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return Array
		 */ 

		public function fetchAll()
		{
		    $results = array();
		    $results = $this->_results->fetch_all (MYSQLI_ASSOC);
		    mysqli_free_result ($this->_results);
		    
			return $results;
		}



		/**
		 * Close database connection
		 *
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return N/A
		 */ 

		public function closeConnection()
		{
			if ($this->isConnected ())
			{
				$this->_dbconn->close();
			}
		}
	}
?>