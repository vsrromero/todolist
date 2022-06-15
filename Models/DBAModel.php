<?php

    Class DBAModel {

        private $dba;
        protected $scheme = 'todolist';
        protected $local = 'localhost';
        protected $user = 'root';
        protected $pass = '';

        public function __construct()
        {
            try {
            $this->dba = new PDO("mysql:dbname=$this->scheme; host=$this->local" , "$this->user" , "$this->pass");
            } catch (PDOException $e) {
                echo 'Database connection error: '.$e->getMessage();
                exit();
            } catch (Exception $e) {
                echo 'General error: '.$e->getMessage();
            }
        }

        //function that select and show all tasks
        public function showAllTasks(){
            $results = array();
            $select = $this->dba->prepare("SELECT * FROM tb_tasks ORDER BY task_inclusion_date");
            $select->execute();
            $results = $select->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

        //counts amount of To Do tasks
        public function selectToDo(){
            
            $select = $this->dba->prepare("SELECT * FROM tb_tasks WHERE task_status = 'ToDo'");
            $select->execute();
            $results = $select->fetchAll(PDO::FETCH_ASSOC);
            return count($results);
        }

        //counts amount of Doing tasks
        public function selectDoing(){
            
            $select = $this->dba->prepare("SELECT * FROM tb_tasks WHERE task_status = 'Doing'");
            $select->execute();
            $results = $select->fetchAll(PDO::FETCH_ASSOC);
            return count($results);
        }
        
        //counts amount of Done tasks
        public function selectDone(){
            
            $select = $this->dba->prepare("SELECT * FROM tb_tasks WHERE task_status = 'Done'");
            $select->execute();
            $results = $select->fetchAll(PDO::FETCH_ASSOC);
            return count($results);
        }

        //function to insert a new task
        public function insertTask($taskAuthor , $taskName , $taskDescription , $taskStatus , $taskComment) {

        $insert = $this->dba->prepare("INSERT INTO tb_tasks(task_author, task_name, task_description, task_status, task_comment) VALUES(:taskAuthor, :taskName, :taskDescription, :taskStatus, :taskComment)");
        $insert->bindValue(":taskAuthor" , $taskAuthor);
        $insert->bindValue(":taskName" , $taskName);
        $insert->bindValue(":taskDescription" , $taskDescription);
        $insert->bindValue(":taskStatus" , $taskStatus);
        $insert->bindValue(":taskComment" , $taskComment);
        $insert->execute();
        }

        //delete one task
        public function deleteTask($taskId){

            $delete = $this->dba->prepare("DELETE FROM tb_tasks where id = :id");
            $delete->bindValue(":id" , $taskId);
            $delete->execute();
        }

        //function to insert a new author
        public function insertAuthor($authorName , $authorEmail){
        
        //check if the author is already registered
        $select = $this->dba->prepare("SELECT id FROM tb_authors WHERE author_email = :author_email");
        $select->bindValue(":author_email" , $authorEmail);
        $select->execute();

        //if any value has returned from data base, it means that the email is already registered
        if($select->rowCount() > 0) {
            
            return false;

            } else {

            $insert = $this->dba->prepare("INSERT INTO tb_authors(author_name, author_email) VALUES(:author_name, :author_email)");
            $insert->bindValue(":author_name" , $authorName);
            $insert->bindValue(":author_email" , $authorEmail);
            $insert->execute();
            return true;

            }
        }

        public function selectAuthors(){
            $select = $this->dba->prepare("SELECT * FROM tb_authors ORDER BY author_name");
            $select->execute();
            $results = $select->fetchAll(PDO::FETCH_ASSOC);
            return $results;
        }

        public function deleteAuthor($authorEmail){
            $delete = $this->dba->prepare("DELETE FROM tb_authors WHERE author_email = :authorEmail");
            $delete->bindValue(":authorEmail" , $authorEmail);
            $delete->execute();
        }

    }

?>