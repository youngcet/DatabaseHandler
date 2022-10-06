# DatabaseHandler

This package prepares and executes MySQL Statements

# Usage
```
require ('MySQL/DatabaseHandler.php');

$dbhandler = new DatabaseHandler();

// prepare the statement (can be a SELECT/INSERT/UPDATE/DELETE)
$sql = $dbhandler->prepareStatement ('SELECT * FROM table WHERE id = ? AND email = ?');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// execute the statement
// 1st parameter is an array of values
// 2nd parameter is the binding string corresponding to the values in that order (i = integer, s = string, d = float, b = blob)
$sql = $dbhandler->executeStatement ([$id, $email], 'is');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// if the query does not require passing values or the WHERE clause (e.g. SELECT * FROM table), pass empty values to executeStatement
$sql = $dbhandler->executeStatement ([], '');


// fetch the results as a single row
$sql = $dbhandler->fetchRow();

// fetch all rows
$sql = $dbhandler->fetchAll();

// close the connection
$dbhandler->closeConnection();
```

Full documentation on the wiki: https://github.com/youngcet/DatabaseHandler/wiki
