<?php

    require_once '../Models/DBAModel.php';
    $numero = new DBAModel();
    
    Class TasksController {

        private $dbastmt;


    public function __construct()
    {
        $this->dbastmt = new DBAModel();
    }
        
    public function countToDo()
    {
        $count = $this->dbastmt->selectToDo();
        return $count;
    }

    public function countDoing()
    {
        $count = $this->dbastmt->selectDoing();
        return $count;
    }

    public function countDone()
    {
        $count = $this->dbastmt->selectDone();
        return $count;
    }

    public function showAllTasks()
    {
        $select = $this->dbastmt->showAllTasks();
        return $select;
    }

    public function insertTask($taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment){

        $insert = $this->dbastmt->insertTask($taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment);

    }

    public function deleteTask($taskId){
        $delete = $this->dbastmt->deleteTask($taskId);
    }
}

?>