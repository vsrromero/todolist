<?php

use Models\AuthorsController;

    require_once '../Models/DBAModel.php';
    require_once '../Controllers/AuthorsController.php';
    $dbastmt = new DBA('todolist','localhost','root','');
    $showAuthors = new AuthorsController();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../public/css/style.css">

    <script type="text/javascript">
        function emailAlert(){
        alert('Email already registered');
        return false;
        }

        function fieldAlert(){
        alert('You must fill all fields');
        return false;
        }
    </script>

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

                <div class="mForm">
                    <div class="mFormLeft">
                        <label for="author">Task Author: </label><br />
                        <label for="task">Task: </label><br />
                        <label for="description">Description: </label><br />
                        <label for="status">Status: </label><br />
                        <label for="comments">Comments: </label><br />
                    </div>
                    <div class="mFormRight">
                            <form action="">
                                <select name="author" placeholder="Task author" id="author" style="width:19em;">
                                    <option value=""></option>
                                    <?php 
                                                $authors = $showAuthors->showAuthors();
        
                                                foreach($authors as $value){
                                        
                                                        echo "<option value='".$value['author_name']."'>".$value['author_name']."</option>";
                                                           
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
                                </select> <br>
                                <textarea name="comments" rows="10" cols="50" placeholder="Further comments about your task, how to do it, when, why, etc..." id="comments"></textarea><br />
                                <input type="submit" value="Add Task">

                            </form>
                        </div>
                </div>
            </div>

            <div class="right">
            <div class="title">
                    <h3>Insert Authors</h3>
            </div>
                <div class="mForm">
                <div class="authors">
                <?php



                ?>
                
                    <div class="mFormLeft">

                        <label for="authorName">Name: </label><br />
                        <label for="email">E-mail: </label><br />
                    
                    </div>

                    <div class="mFormRight">
                            <form action="" method="_GET">
                                <input name="authorName" type="text" size="30" placeholder="Author Name" id="authorName"> <br />
                                <input name="email" type="email" size="30" placeholder="author@email.com" id="email"> <br />
                                <input type="submit" value="Add Author">
                            </form>
                    <div>&nbsp;
                    <?php 
                    
                    if(isset($_GET["authorName"]))
                    {
                        $authorName = addslashes($_GET["authorName"]);
                        $email = addslashes($_GET["email"]);
                        if (!empty($authorName) && !empty($email)){
                            if (!$dbastmt->insertAuthor($authorName , $email))
                            {
                                echo 'Email already registered';
                            }
                             
                            
                        } else {
                            echo 'You must fill every field';
                        }

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
                        $count = $dbastmt->countToDo();
                        echo $count;
                    ?>    
                    <br />
                    <?php 
                        //Count and return how many 'Doing' Results on tasks
                        $count = $dbastmt->countDoing();
                        echo $count;
                    ?>  
                    <br />
                    <?php 
                        //Count and return how many 'Done' Results on tasks
                        $count = $dbastmt->countDone();
                        echo $count;
                    ?>
                    <br />

                    </div>
                </div>

            </div>

        </section>

        <section>

                <?php 

                    $tasks = $dbastmt->showAllTasks();
                    if (count($tasks)>0)
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
                        foreach ($tasks as $row){
                            echo "<tr>";
                            foreach ($row as $key => $value){
                                echo "<td class='$key'>$value</td>";
                            }
                            echo '<td class="actions"><a href="#">Edit</a> <a href="#">Delete</a> </td>';
                            echo "</tr>";
                            echo "</table>";
                        }
                    }

                    else{
                        echo "<div style='margin-top: 15px;'>
                                <h3>No task to show</h3>
                            </div>";
                    }

                ?>
            </table>
        </section>
    </main>

    <footer>
    
    </footer>

    <?php 


        

        
    ?>


</body>
</html>
