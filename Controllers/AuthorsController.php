<?php
    namespace Models;
    use DBA;

    Class AuthorsController extends DBA{

        public function __construct()
        {
            parent::__construct('todolist' , 'localhost' , 'root' , '');
        }
    
        public function showAuthors()
        {
            $authors = $this->selectAuthors();
            return $authors;
            
        }
      
    }
?>