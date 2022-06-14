<?php

//connection
try {

    $dba = new PDO("mysql:dbname=todolist; host=localhost", "root", "192837Vr!");
    //in case of database connection error
    } catch (PDOException $e) {

    echo "Database connection error: " . $e->getMessage();

    //in case of any other error
    } catch (Exception $e) {

    echo "General error: " . $e->getMessage();

    }

//end connection


//variables
$id = 1;
$taskAuthor = 'Niamh Romero';
$taskName = 'Play a lot';
$taskDescription = 'Play and sing the whole day';
$taskStatus = 'To Do';
$taskComment = 'This task ends only after 15 years old';
$userName = 'Jinx Bites';
$userNick = 'jbites';
$userEmail = 'jinxbites@hotmail.com';
//end variables

//functions CRUD

//function to insert a new user
function insertUser($dba, $userName , $userNick , $userEmail){

    $insert = $dba->prepare("INSERT INTO tb_users(u_name, user_nick, user_email) VALUES(:un, :uni, :ue)");
    $insert->bindParam(":un" , $userName);
    $insert->bindParam(":uni" , $userNick);
    $insert->bindParam(":ue" , $userEmail);
    $insert->execute();

}

//uncomment line below to insert a new user
//insertUser($dba , $userName , $userNick , $userEmail);

//function to insert a new task
function insertTask($dba , $taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment) {

    $insert = $dba->prepare("INSERT INTO tb_tasks(task_author, task_name, task_description, task_status, task_comment) VALUES(:taskAuthor, :taskName, :taskDescription, :taskStatus, :taskComment)");
    
    $insert->bindParam(":taskAuthor" , $taskAuthor);
    $insert->bindParam(":taskName" , $taskName);
    $insert->bindParam(":taskDescription" , $taskDescription);
    $insert->bindParam(":taskStatus" , $taskStatus);
    $insert->bindParam(":taskComment" , $taskComment);
    $insert->execute();

}

//uncomment line below to insert a new task
//insertTask($dba , $taskAuthor , $taskAuthor , $taskDescription , $taskStatus , $taskComment);




//function that select all tasks
function showAllTasks($dba){
    $select = $dba->prepare("SELECT task_name , task_description , task_status , task_comment , task_author , task_inclusion_date FROM tb_tasks");
    $select->execute();
    return $results = $select->fetchAll(PDO::FETCH_ASSOC);
}


//function that select specific task
function showOneTask($dba , $id) {

    $select = $dba->prepare("SELECT task_name , task_description , task_status , task_comment , task_author , task_inclusion_date FROM tb_tasks WHERE id = :id");
    $select->bindParam(':id' , $id);
    $select->execute();
    return $result = $select->fetch(PDO::FETCH_ASSOC);
}

//function to delete a task
function deleteTask($dba , $id) {
    $delete = $dba->prepare("DELETE FROM tb_tasks WHERE id = :id");
    $delete->bindParam(':id' , $id);
    $delete->execute();
}

//uncomment the line below to delete a task
//deleteTask($dba , $id);

//function to delete an user
function deleteUser($dba , $id) {
    $delete = $dba->prepare("DELETE FROM tb_author WHERE id = :id");
    $delete->bindParam(':id' , $id);
    $delete->execute();
}

//uncomment the line below to delete an user
//deleteUser($dba ,$id);

?>

<body>
    <?php 
    
    foreach (showOneTask($dba , $id)  as $key => $value) {
        echo $key . ": " . $value . "<br>";
    }

    echo "<hr>";

    foreach (showAllTasks($dba) as $row) {
        echo "Task <br>";
        foreach ($row as $key => $value){
            echo $value . "<br>";
        }
        echo "<hr>";
    }
    
    ?>
</body>