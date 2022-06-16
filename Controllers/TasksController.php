<?php

    require_once '../Models/DBAModel.php';
    $numero = new DBAModel();
    
    Class TasksController {

        private $dbastmt;

    
    public function __construct() {
        $this->dbastmt = new DBAModel();
    }
    //count ToDo tasks    
    public function countToDo() {
        $count = $this->dbastmt->selectToDo();
        return $count;
    }
    //count Doing tasks
    public function countDoing() {
        $count = $this->dbastmt->selectDoing();
        return $count;
    }
    //count Done tasks
    public function countDone() {
        $count = $this->dbastmt->selectDone();
        return $count;
    }
    //show all tasks - return SELECT * FROM tb_tasks
    public function showAllTasks() {
        $select = $this->dbastmt->showAllTasks();
        return $select;
    }
    //insert task
    public function insertTask($taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment) {
        $insert = $this->dbastmt->insertTask($taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment);

    }
    //delete task
    public function deleteTask($taskId) {
        $delete = $this->dbastmt->deleteTask($taskId);
    }

    //select task per id
    public function selectTaskPerId($id) {
        $select = $this->dbastmt->selecTasktById($id);
        return $select;
    }

    //update task
    public function updateTask($id) {
        $update = $this->dbastmt->updateTask($id);
    }
}

?>