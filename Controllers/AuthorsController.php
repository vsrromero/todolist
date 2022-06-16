<?php
    
    require_once '../Models/DBAModel.php';

    Class AuthorsController {

        private $dbastmt;

        public function __construct() {
            $this->dbastmt = new DBAModel();
        }
        //select all authors
        public function showAllAuthors() {
            $authors = $this->dbastmt->selectAuthors();
            return $authors;
            
        }
        //insert author
        public function insertAuthor($authorName, $authorEmail) {
            $result = $this->dbastmt->insertAuthor($authorName , $authorEmail);
            return $result;
        }
        //delete author
        public function deleteAuthor($authorEmail) {
            $this->dbastmt->deleteAuthor($authorEmail);
        }
      
    }

?>