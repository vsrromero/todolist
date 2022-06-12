<?php

//connection
try {

    $dba = new PDO("mysql:dbname=todolist; host=localhost", "root", "");
//in case of database connection error
} catch (PDOException $e) {

    echo "Database connection error: " . $e->getMessage();

    //in case of any other error
} catch (Exception $e) {

    echo "General error: " . $e->getMessage();

}
//end connection


//query

//insert
$taskAuthor = 'Victor Romero';
$taskName = 'Pay Mortgage';
$taskDescription = 'Mortgage must be paid till every day 30';
$taskStatus = 'To Do';
$taskComment = 'When the last day of the month is a weekend, it will be paid at the first working day of the next month';
$userName = 'Thayana Triacca';
$userNick = 'ttriacca';
$userEmail = 'sweethay@hotmail.com';

/*
$insertMain = $dba->prepare("INSERT INTO tb_users(u_name, user_nick, user_email) VALUES(:un, :uni, :ue)");
$insertMain->bindParam(":un" , $userName);
$insertMain->bindParam(":uni" , $userNick);
$insertMain->bindParam(":ue" , $userEmail);
$insertMain->execute();


$insertMain = $dba->prepare("INSERT INTO tb_tasks(task_author, task_name, task_description, task_status, task_comment) VALUES(:ta, :tn, :td, :ts, :tc)");

$insertMain->bindParam(":ta" , $taskAuthor);
$insertMain->bindParam(":tn" , $taskName);
$insertMain->bindParam(":td" , $taskDescription);
$insertMain->bindParam(":ts" , $taskStatus);
$insertMain->bindParam(":tc" , $taskComment);
$insertMain->execute();
*/
?>