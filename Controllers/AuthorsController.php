<?php
    
    require_once '../Models/DBAModel.php';

    Class AuthorsController {

        private $dbastmt;

        public function __construct()
        {
            $this->dbastmt = new DBAModel();
        }

        public function showAuthors()
        {
            $authors = $this->dbastmt->selectAuthors();
            return $authors;
            
        }

        public function insertAuthor($authorName, $authorEmail)
        {
            $result = $this->dbastmt->insertAuthor($authorName , $authorEmail);
            return $result;
        }
      
    }

?>