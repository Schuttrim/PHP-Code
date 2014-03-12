<?php
    
    /*
    Stands for the given permissions to an article
    Params: 
        - User as result of database::getuser()
        - article as result of database::getarticles()
        
    If only user known, you simply can just get basic right of user (suchas create new article, create new user)
    */
    class permission {
        private $user;
        private $article;
        
        public function __construct($user, $article) {
            $this->user = $user;
            $this->article = $article;
        }
        /* php cha das nid -.-
        public function __construct($user) {
            $this->user = $user;
        }*/
        
        public function hasnewarticlepermission() {
            return empty($this->user) ? false : true;
        }
        public function hasuseradminpermission() {
        }
        
        public function hasdeletepermission() {
            $retval = false;
            if(empty($this->user) ? false : (empty($this->article) ? false :($this->user->Berechtigung == 'admin' || $this->user->id == $this->article->uid))) {
                $retval = true;
            }
            return $retval;
        } 
        public function haseditpermission() {
            $retval = false;
            if(empty($this->user) ? false : (empty($this->article) ? false :($this->user->id == $this->article->uid))) {
                $retval = true;
            }
            return $retval;
        }
        public function hascommentpermission() {
            $retval = false;
            if(empty($this->user) ? false : true) {
                $retval = true;
            }
            return $retval;
        }
    }
    
?>