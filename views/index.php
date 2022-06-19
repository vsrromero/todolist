<?php

    require_once '../Controllers/AuthorsController.php';
    require_once '../Controllers/TasksController.php';
    $authorstmt = new AuthorsController();
    $taskstmt = new TasksController();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <header>
        <div class="top"><h1>My To Do List</h1></div>
    </header>

    <main>

        <section>

            <div class="left">
                <div class="title">
                    <h3>Create your task</h3>
                </div>
                <!--left form to create tasks-->

                <?php 
                
                    //update task
                    if(isset($_GET['update_id'])) {
                    $taskId = addslashes($_GET['update_id']);
                    $taskRetrived = $taskstmt->selectTaskPerId($taskId);

                    }            

                
                ?>

                <div class="mForm">
                    <div class="mFormLeft">
                        <label for="author">Task Author:* </label><br />
                        <label for="task">Task:* </label><br />
                        <label for="description">Description:* </label><br />
                        <label for="status">Status:* </label><br />
                        <label for="comments">Comments: </label><br />
                    </div>
                    <div class="mFormRight">
                        <form action="index.php" method="POST">
                            <!-- a php block is in all value on this form to set the retrived data from database on fields in case the variable $taskRetrived is set, this variable will be set once 'edit' is clicked, once it is clicked the method $_GET is called through the href tag <a href="uri?foo="> and get the data from database HINT: ctrl+click to check dependencies -->
                            <select name="author" id="author" style="width:19em;">
                                <option value=""></option>
                                <?php 
                                //Get the authors from DB and insert them into a <select> menu.
                                            $authors = $authorstmt->showAllAuthors();
    
                                            foreach($authors as $value) {
                                                    echo "<option value='".$value['author_email']."'>".$value['author_email'] . " - " . $value['author_name'] ."</option>";
                                            }
                                ?>
                            </select> <br />
                            <input name="task" type="text" size="31" placeholder="My task" id="task" value="<?php if(isset($taskRetrived)){echo $taskRetrived['task_name'];} ?>"> <br />
                            <input name="description" type="text" size="31" placeholder="What is your task about?" id="description" value="<?php if(isset($taskRetrived)){echo $taskRetrived['task_description'];} ?>"> <br />
                            <select name="status" id="status">
                                <option value=""></option>
                                <option value="ToDo">To Do</option>
                                <option value="Doing">Doing</option>
                                <option value="Done">Done</option>
                            </select> <br />
                            <textarea name="comments" rows="10" cols="50" placeholder="Further comments about your task, how to do it, when, why, etc..." id="comments" value="<?php if(isset($taskRetrived)){echo $taskRetrived['task_comment'];} ?>"></textarea><br />
                            <input type="submit" value="<?php if(isset($taskRetrived)){echo 'Update task';} else {echo 'Add task';} ?>"> <!-- if $taskRetrived is set, then shows Update task as value on button, else, shows Add task as value-->
                            <div>&nbsp;
                            <?php 
                            
                                //delete task
                                if(isset($_GET['id'])) {
                                    $taskId = addslashes($_GET['id']);
                                    $taskstmt->deleteTask($taskId);

                                }

                                //create task
                                if(isset($_POST['author'])) {
                                    $taskAuthor = addslashes($_POST['author']);
                                    $task = addslashes($_POST['task']);
                                    $taskDescription = addslashes($_POST['description']);
                                    $taskStatus = addslashes($_POST['status']);
                                    $taskComments = addslashes($_POST['comments']);
                                    if(!empty($taskAuthor) && !empty($task) && !empty($taskDescription) && !empty($taskStatus)){
                                        $taskstmt->insertTask($taskAuthor , $task , $taskDescription , $taskStatus , $taskComments);
                                    } else {
                                        echo '<span class="warning">You must fill all mandatory (*) fields.</span>';
                                    }

                                }

                            ?>
                            </div>
                        </form>
                    </div>
                <!--end of left form to create tasks-->
                </div>
            </div>

            <div class="right">
            <div class="title">
                    <h3>Authors</h3>
            </div>
                <div class="mForm">
                    <div class="authors">
                        <div class="mFormLeft">
                            <h4>&nbsp;</h4>
                            <label for="authorName">Name: </label><br />
                            <label for="email">E-mail: </label><br />
                        
                        </div>
                        <div class="mFormRight">
                                <h4>Insert new Author</h4>
                                <form action="index.php?" method="POST">
                                    <input name="authorName" type="text" size="30" placeholder="Author Name" id="authorName"> <br />
                                    <input name="email" type="email" size="30" placeholder="author@email.com" id="email"> <br />
                                    <input name="submitBtn"type="submit" value="Add Author">
                                </form>
                        <div>&nbsp;
                        <?php 
                        //register a new Author
                        if(isset($_POST["authorName"])) {
                            $authorName = addslashes($_POST["authorName"]);
                            $email = addslashes($_POST["email"]);
                            if (!empty($authorName) && !empty($email)){

                            if(!$authorstmt->insertAuthor($authorName , $email)) {
                                echo '<span class="warning">Email already registered</span>';
                            }
                                
                            } else {
                                echo '<span class="warning">You must fill every field</span>';
                            }


                        }

                        ?>
                        </div>
                        </div>
                    </div>
                    <!--Delete author section-->
                    <?php
                    if(isset($_POST['delAuthor'])){
                        $emailAuthor = $_POST['delAuthor'];
                        $authorstmt->deleteAuthor($emailAuthor);
                    }
                ?>
                    <div class="mFormDelete" style="margin-left: 10%"> 
                        <h4>Delete Authors</h4>
                        <form action="" method="POST">
                            <select name="delAuthor" style="width:19em;">
                                <option value="">Select the author e-mail to be deleted.</option>
                                <?php 
                                //Get the authors from DB and insert them into a <select> menu.
                                            $authors = $authorstmt->showAllAuthors();
    
                                            foreach($authors as $value){
                                    
                                                    echo "<option value='".$value['author_email']."'>".$value['author_email'] ."</option>";
                                                        
                                            }

                                ?>
                            </select>
                            <input type="submit" value="Delete">

                        </form>
                    </div>
                </div>

                <div class="tasksSummary">
                    <h3>Task Sumary</h3>
                    <div class="tasksTitles">
                        Tasks To do: <br />
                        Tasks Doing: <br />
                        Tasks Done: <br />
                    </div>
                    <div class="tasksData">
                    <?php 
                        //Count and return how many 'To Do' Results on tasks
                        $count = $taskstmt->countToDo();
                        echo $count;
                    ?>    
                    <br />
                    <?php 
                        //Count and return how many 'Doing' Results on tasks
                        $count = $taskstmt->countDoing();
                        echo $count;
                    ?>  
                    <br />
                    <?php 
                        //Count and return how many 'Done' Results on tasks
                        $count = $taskstmt->countDone();
                        echo $count;
                    ?>
                    <br />

                    </div>
                </div>

            </div>

        </section>

        <section>

                <?php 
  
                //show tasks
                    $tasks = $taskstmt->showAllTasks();
                    //check if there are tasks registered, if yes create a table, if not show message of no tasks to show
                    if (count($tasks)>0) {
                        echo
                        '<table>
                        <th>Task</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Comment</th>
                        <th>Author</th>
                        <th>Inclusion Date</th>
                        <th></th>';
                        for ($i = 0 ; $i < count($tasks)  ; $i++){
                            echo "<tr>";
                            foreach ($tasks[$i] as $key => $value){
                                if ($key != 'id' && $key != 'task_conclusion_date' && $key != 'task_done_by'){
                                echo "<td class='$key'>$value</td>";
                                }
                            }
                            echo    '<td class="actions">
                                        <a href="index.php?update_id='.$tasks[$i]['id'].'">Edit</a> 
                                        <a href="index.php?id='.$tasks[$i]['id'].'">Delete</a> 
                                    </td>';
                            echo "</tr>";
                        }
                    }
                    
                    else{
                        echo "<div style='margin-top: 15px;'>
                        <h3>No task to show</h3>
                        </div>";
                    }
                    echo "</table>";
                    
                ?>
            </table>
        </section>
    </main>

    <footer>

    </footer>

</body>
</html>

<?php

$dados = [
    
    ['thay','triacca','05465764'],
    ['victor','romero','65655656']
];
echo '<pre>';
var_dump($dados);
echo '</pre>';


foreach($dados as $row);
    foreach($row as $key => $value){
        echo $value;
    }


?>