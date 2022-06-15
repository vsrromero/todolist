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
                            <select name="author" placeholder="Task author" id="author" style="width:19em;">
                                <option value=""></option>
                                <?php 
                                //Get the authors from DB and insert them into a <select> menu.
                                            $authors = $authorstmt->showAuthors();
    
                                            foreach($authors as $value){
                                    
                                                    echo "<option value='".$value['author_email']."'>".$value['author_email'] . " - " . $value['author_name'] ."</option>";
                                                        
                                            }
                                ?>
                            </select> <br />
                            <input name="task" type="text" size="31" placeholder="My task" id="task"> <br />
                            <input name="description" type="text" size="31" placeholder="What is your task about?" id="description"> <br />
                            <select name="status" id="status">
                                <option value=""></option>
                                <option value="ToDo">To Do</option>
                                <option value="Doing">Doing</option>
                                <option value="Done">Done</option>
                            </select> <br />
                            <textarea name="comments" rows="10" cols="50" placeholder="Further comments about your task, how to do it, when, why, etc..." id="comments"></textarea><br />
                            <input type="submit" value="Add Task">
                            <div>&nbsp;
                            <?php 
                            
                                //delete task
                                if(isset($_GET['id']))
                                {
                                    $taskId = addslashes($_GET['id']);
                                    $taskstmt->deleteTask($taskId);
                                    header("location: index.php");

                                }
                                //create task
                                if(isset($_POST['author'])){
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
                    <h3>Insert Authors</h3>
            </div>
                <div class="mForm">
                <div class="authors">

                    <div class="mFormLeft">

                        <label for="authorName">Name: </label><br />
                        <label for="email">E-mail: </label><br />
                    
                    </div>

                    <div class="mFormRight">
                            <form action="index.php?" method="POST">
                                <input name="authorName" type="text" size="30" placeholder="Author Name" id="authorName"> <br />
                                <input name="email" type="email" size="30" placeholder="author@email.com" id="email"> <br />
                                <input type="submit" value="Add Author">
                            </form>
                    <div>&nbsp;
                    <?php 
                    //register a new Author
                    if(isset($_POST["authorName"]))
                    {
                        $authorName = addslashes($_POST["authorName"]);
                        $email = addslashes($_POST["email"]);
                        if (!empty($authorName) && !empty($email)){

                           if(!$authorstmt->insertAuthor($authorName , $email))
                           {
                               echo '<span class="warning">Email already registered</span>';
                           }
                            
                        } else {
                            echo '<span class="warning">You must fill every field</span>';
                        }
                        header("Refresh:0");
                    }

                    ?>
                    </div>
                    </div>
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
                    if (count($tasks)>0) //check if there are tasks registered, if yes create a table, if not show message of no tasks to show
                    {
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
                            echo '<td class="actions"><a href="#">Edit</a> <a href="index.php?id='.$tasks[$i]['id'].'">Delete</a> </td>';
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




?>
