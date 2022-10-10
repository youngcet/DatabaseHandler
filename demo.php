<?php

    require ('autoloader.php');

    $dbhandler = new DatabaseHandler();

    // PREPARE SINGLE SQL STATEMENT
    $sql = $dbhandler->prepareStatement ('SELECT * FROM table WHERE id = ? AND email = ?');
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    $sql = $dbhandler->executeStatement ([6, 'young.cet@gmail.com'], 'is');
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    ####################################################################################################################

    // PREPARING MULTIPLE QUERIES
    $queries = 
        [
            'SELECT_ALL_USERS' => 'SELECT * FROM table', 
            'SELECT_USER' => 'SELECT * FROM table WHERE id = ?',
            'INSERT_USER' => 'INSERT INTO table (fname, lname, email) VALUES (?,?,?)'
        ];

    $sql = $dbhandler->loadQueries ($queries);
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    $sql = $dbhandler->executeLoadedQuery ('SELECT_ALL_USERS', [], ''); // argument 2 & 3 are empty since this statement does not have a where clause
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    // // fetch the results
    print_r($dbhandler->fetchAll());

    $sql = $dbhandler->executeLoadedQuery ('SELECT_USER', [6], 'i');
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    // fetch the results
    print_r($dbhandler->fetchRow());
    
    $sql = $dbhandler->executeLoadedQuery ('INSERT_USER', ['yung', 'cet', 'young.cet@gmail.com'], 'sss');
    if (App\Custom\Error::IsAnError ($sql))
    {
        die ('Error: '.$sql->GetError());
    }

    $dbhandler->closeConnection();
?>