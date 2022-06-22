<?php

    require_once '../Controllers/AuthorsController.php';
    require_once '../Controllers/TasksController.php';
    require_once 'templates/GeneralTemplates.php';

    $authorstmt = new AuthorsController();
    $taskstmt = new TasksController();
    $templates = new GeneralTemplates();
    
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
                    if(isset($_GET['update_id'])) { //this check, validate if the edit button was clicked
                    $taskId = addslashes($_GET['update_id']);
                    $taskRetrived = $taskstmt->selectTaskPerId($taskId);
                    }            
                
                ?>

                <div class="mForm">
                    <div class="mFormLeft">
                        <label for="author">Task Author:* </label><br />
                        <label for="task">Task:* </label><br />
                        <label for="status">Status:* </label><br />
                        <label for="comments">Comments: </label><br />
                    </div>
                    <div class="mFormRight">
                        <form action="index.php" method="POST">
                            <!-- a php block is in all value on this form to set the retrived data from database on fields in case the variable $taskRetrived is set, this variable will be set once 'edit' is clicked, once it is clicked the method $_GET is called through the href tag <a href="uri?foo="> and get the data from database HINT: ctrl+click to check dependencies -->
                            <select name="author" id="author" style="width:19em;">
                                <option value=""></option>
                                <?php
                                $templates->selectMenuAuthors();
                                ?>
                            </select> <br />
                            <input name="task" type="text" size="31" placeholder="My task" id="task" value="<?php if(isset($taskRetrived)){echo $taskRetrived['task_name'];} ?>"> <br />
                            <select name="status" id="status">
                                <option value=""></option>
                                <option value="ToDo">To Do</option>
                                <option value="Doing">Doing</option>
                                <option value="Done">Done</option>
                            </select> <br />
                            <textarea name="comments" rows="10" cols="50" placeholder="Further comments about your task, how to do it, when, why, etc..." id="comments" ><?php if(isset($taskRetrived)){echo $taskRetrived['task_comment'];} ?></textarea><br />
                            <input type="submit" value="<?php if(isset($taskRetrived)){echo 'Update task';} else {echo 'Add task';} ?>"> <!-- if $taskRetrived is set, then shows Update task as value on button, else, shows Add task as value-->
                            <div>&nbsp;
                            <?php 
                            
                                //delete task
                                if(isset($_GET['id'])) {
                                    $taskstmt->deleteTask($_GET['id']);
                                }

                                //insert / update task
                                if(isset($_POST['author'])) {

                                    if(isset($taskRetrived)) //check if edit button was clicked
                                    //--------------------------------------- EDIT ------------------------------------------
                                    { 
                                        $idUpdate = addslashes($_GET['update_id']);
                                        $task = addslashes($_POST['task']);
                                        $taskStatus = addslashes($_POST['status']);
                                        $taskComments = addslashes($_POST['comments']);
                                        $taskAuthor = addslashes($_POST['author']);
                                        if(!empty($taskAuthor) && !empty($task) && !empty($taskStatus)){
                                            $taskstmt->updateTask($idUpdate, $task , $taskStatus , $taskComments , $taskAuthor);
                                        } else {
                                            echo '<span class="warning">You must fill all mandatory (*) fields.</span>';
                                        }
                                    } else {
                                        //-------------------------------------- INSERT ------------------------------------------
                                        $taskAuthor = addslashes($_POST['author']);
                                        $task = addslashes($_POST['task']);
                                        $taskStatus = addslashes($_POST['status']);
                                        $taskComments = addslashes($_POST['comments']);
                                        if(!empty($taskAuthor) && !empty($task) && !empty($taskStatus)){
                                            $taskstmt->insertTask($taskAuthor , $task , $taskStatus , $taskComments);
                                        } else {
                                            echo '<span class="warning">You must fill all mandatory (*) fields.</span>';
                                        }
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
                                $templates->selectMenuAuthors();
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
                        Tasks Done: 
                    </div>
                    <div class="tasksData">
                    <?php 
                        
                        $templates->countTasksToDo();
                        echo '<br>';
                        $templates->countTasksDoing();
                        echo '<br>';
                        $templates->countTasksDone();
                        
                    ?>
                    <br />

                    </div>
                </div>

            </div>

        </section>

        <section>
                <?php 
                    $templates->showTasksOnTable();
                ?>
            </table>
        </section>
    </main>

    <footer>

    </footer>

</body>
</html>


