<?php
require_once '../Controllers/TasksController.php';
require_once '../Controllers/AuthorsController.php';

    Class GeneralTemplates{

        private $taskstmt;
        private $authorstmt;

        public function __construct()
        {
            $this->taskstmt = new TasksController();
            $this->authorstmt = new AuthorsController();
        }
        
        //Generate a table with all tasks from database

        public function showTasksOnTable()
        {

            //show tasks
                    //array with all tasks
                    $tasks = $this->taskstmt->showAllTasks();
                    //check if there are tasks registered, if yes create a table, if not show message of no tasks to show
                    if (count($tasks)>0) {
                        echo
                        '<table>
                        <th>Task</th>
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
        }
        // END generate a table with all tasks from database

        ///////////////////////////////////////////////////////

        // Generate <select> <option> with all authors
        // get the authors from DB and insert them into a <select> menu.

        public function selectMenuAuthors(){
        $authors = $this->authorstmt->showAllAuthors();
                                                    
            foreach($authors as $value) {
                        echo "<option value='".$value['id']."'>".$value['author_email'] . " - " . $value['author_name'] ."</option>";
                }
       
        }
        // END generate <select> <option> with all authors

        ///////////////////////////////////////////////////////

        // Count amount of each task

        //count and return how many 'To Do' Results on tasks
        public function countTasksToDo(){
            $count = $this->taskstmt->countToDo();
            echo $count;
        }
        
        //count and return how many 'Doing' Results on tasks
        public function countTasksDoing(){
            $count = $this->taskstmt->countDoing();
            echo $count;
        }
         
        //count and return how many 'Done' Results on tasks
        public function countTasksDone(){
            $count = $this->taskstmt->countDone();
            echo $count;
        }
         

        // END count amount of each task

        ///////////////////////////////////////////////////////

    }

?>