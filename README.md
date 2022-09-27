# DatabaseHandler

This package prepares and executes MySQL Statements

# Usage
```
require ('MySQL/DatabaseHandler.php');

$dbhandler = new DatabaseHandler();

// prepare the statement
$sql = $dbhandler->prepareStatement ('SELECT * FROM table WHERE id = ? AND email = ?');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// execute the statement
// 1st parameter is an array of values
// 2nd parameter is the binding string corresponding to the values in that order
$sql = $dbhandler->executeStatement ([$id, $email], 'is');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// fetch the results as a single row
$sql = $dbhandler->fetchRow();

// fetch all rows
$sql = $dbhandler->fetchAll();

// close the connection
$dbhandler->closeConnection();
```
