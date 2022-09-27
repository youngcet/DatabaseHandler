<?php

	/**
	 * Database Object
	 *
	 * This class connects to the database
	 *
	 * @category   MySQL
	 * @package    Database
	 * @author     Cedric Maenetja <cedricm@permanentlink.co.za>
	 * @copyright  2022 Permanent Link CO
	 * @license    Permanent Link CO
	 * @version    Release: 1.0
	 */

	class Database
	{
		private $servername;
		private $username;
		private $password;
		private $dbname;

		protected function connect()
		{
			$this->servername = "localhost";	# host
            $this->username = "root";			# user
            $this->password = "";				# password
            $this->dbname = "giftcards";		# database name

			$conn = new mysqli ($this->servername, $this->username, $this->password, $this->dbname);

			if ($conn->connect_errno)
			{
				return 0;
			}

			return $conn;
		}

		protected function close()
		{
			mysqli_close ($this->connect());
		}
	}
?>