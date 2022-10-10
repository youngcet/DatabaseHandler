<?php
	
	require_once ("Database.php");
	require_once ("Error.php");

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
	 * @version    Release: 1.0.1
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
			$this->_queries = array();
			$this->_isdbconnclosed = false;
		}



		/**
		 * Connects to the database
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return database object
		 */ 

		public function isConnected()
		{
			// check if connection was closed
			if ($this->_isdbconnclosed) $this->_dbconn = new App\Custom\Error (-1, "The Database connection is already closed!");

			return (App\Custom\Error::IsAnError ($this->_dbconn)) ? $this->_dbconn : true;
		}
        


		/**
		 * Load sql queries from an array
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return 1 or App\Custom\Error
		 */

		public function loadQueries ($queries)
		{
			if (! is_array ($queries)) $queries = new App\Custom\Error (-1, "[$queries] not an Array!");

			if (! App\Custom\Error::IsAnError ($queries))
			{
				foreach ($queries as $key => $value) $this->_queries[$key] = $value;
			}

			return (App\Custom\Error::IsAnError ($queries)) ? $queries : 1;
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
			if (App\Custom\Error::IsAnError ($this->isConnected()))
			{
				return $this->_dbconn;
			}

			if (! $this->_stmt = $this->_dbconn->prepare ($sqlStatement))
			{
				return new App\Custom\Error (-1, $this->_dbconn->error);
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
			if (App\Custom\Error::IsAnError ($this->isConnected()))
			{
				return $this->_dbconn;
			}

		    if (! empty ($values) && ! empty ($valueType)) 
			{
				try
				{
					$this->_stmt->bind_param ($valueType, ...$values);
				}
				catch (ArgumentCountError $e)
				{
					return new App\Custom\Error (-1, $e->GetMessage());
				}
			}
		
			if (! $this->_stmt->execute())
			{
				return new App\Custom\Error (-1, $this->_stmt->error);
			}

			$this->_results = $this->_stmt->get_result();
			$this->_stmt->close();

			return 1;

		}



		/**
		 * execute a single sql queries from an array
		 * 
		 * @author Cedric Maenetja <cedricm@permanentlink.co.za>
		 * @return true or App\Custom\Error
		 */

		public function executeLoadedQuery ($key, $values, $bindingstring)
		{
			$results = true;
			if (! array_key_exists ($key, $this->_queries)) $results = new App\Custom\Error (-1, "SQL Query [$key] does not exist!");
			
			if (! App\Custom\Error::IsAnError ($results))
			{
				$sql = $this->prepareStatement ($this->_queries[$key]);
				$results = (App\Custom\Error::IsAnError ($sql)) ? $sql : $this->executeStatement ($values, $bindingstring);
			}

			return $results;
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
			if (! App\Custom\Error::IsAnError ($this->isConnected()))
			{
				$this->_isdbconnclosed = true;
				$this->_dbconn->close();
			}
		}
	}
?>
