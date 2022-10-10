# DatabaseHandler

This package prepares and executes MySQL Statements

# Usage

```
require ('autoloader.php');

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
$sql = $dbhandler->executeStatement ([6, 'young.cet@gmail.com'], 'is');
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


####################################################################################################################

// LOADING MULTIPLE SQL QUERIES
$queries = 
    [
        'SELECT_ALL_USERS' => 'SELECT * FROM table', 
        'SELECT_USER' => 'SELECT * FROM table WHERE id = ?',
        'INSERT_USER' => 'INSERT INTO table (fname, lname, email) VALUES (?,?,?)'
    ];

$sql = $dbhandler->loadQueries ($queries);
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

$sql = $dbhandler->executeLoadedQuery ('SELECT_ALL_USERS', [], ''); // argument 2 & 3 are empty since this statement does not have a where clause
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// // fetch the results
print_r($dbhandler->fetchAll());

$sql = $dbhandler->executeLoadedQuery ('SELECT_USER', [6], 'i');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// fetch the results
print_r($dbhandler->fetchRow());

$sql = $dbhandler->executeLoadedQuery ('INSERT_USER', ['yung', 'cet', 'young.cet@gmail.com'], 'sss');
if (App\Custom\Error::IsAnError ($sql))
{
    // handle error
    // $sql->GetError() // get error message
    // $sql->GetErrorCode() // get error code
}

// close the connection
$dbhandler->closeConnection();
```

Full documentation on the wiki: https://github.com/youngcet/DatabaseHandler/wiki
