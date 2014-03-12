<?php

    class database {
        private $hostname;
        private $username;
        private $password;
        private $standardschema;
        
        public function __construct($hostname, $username, $password, $standardschema){
            $this->hostname = $hostname;
            $this->username = $username;
            $this->password = $password;
            $this->standardschema = $standardschema;
        }
        
        /* Lists all articles */
        public function getarticles() {
            $retval = false;
            
            if($db = $this->login()){
                if($result = $this->getobjectarr($db->query("SELECT b.id id, u.id uid, u.nickname nickname, b.creationdate creationdate, b.topic topic, b.content content FROM beitrag b, users u WHERE b.user_id = u.id ORDER BY creationdate DESC;")))
                {
                    if(count($result) > 0) {
                        $retval = $result;
                    }
                }
                $this->logout($db);
            }
            return $retval;
        }
        
        /*
        Returns user with id or false
        */
        public function getuser($id) {
            $retval = false;
            
            if($db = $this->login()){
                if($result = $this->getobjectarr($db->query("SELECT u.id id, u.name Name, u.vorname Vorname, u.nickname Nickname, m.name Berechtigung FROM users u, modes m WHERE u.modus = m.id AND u.id = " . $id . ";")))
                {
                    if(count($result) > 0) {
                        $retval = $result[0];
                    }
                }
                $this->logout($db);
            }
            
            
            return $retval;
        }
       
        
        /*
        Returns all articles of Blog of false if no articles
        
        ATTENTION: DEPRECATED
        
        public function getarticles() {
            $retval = false;
            
            if($db = $this->login()){
                if($result = $this->getobjectarr($db->query("SELECT b.id ID, u.name Name, u.vorname Vorname, b.topic Topic, b.content Content, b.creationdate Creationdate FROM blog.beitrag b, blog.users u where u.id = b.user_id;")))
                {
                    if(count($result) > 0) {
                        $retval = $result;
                    }
                }
                $this->logout($db);
            }
            
            
            return $retval;
        }*/
        
        /*
        Validates if user password comination is correct
        id if correct
        false if not valid */
        public function isvalidpwuser($username, $password) {
            $retval = false;
            
            if($db = $this->login()){
                if($result = $this->getobjectarr($db->query("SELECT count(name) as countrows, id as ID FROM blog.users where nickname = '" . $username . "' AND passwort = MD5('" . $password . "');")))
                {
                    if($result[0]->countrows == 1) {
                        $retval = $result[0]->ID;
                    }
                }
                $this->logout($db);
            }
            
            
            return $retval;
        }
        
        
        /* Insert a query result and get object array or false if query failed */
        private function getobjectarr($result) {
            $arr = [];
            
            if($result) {
                while($row = $result->fetch_object()) {
                    $arr[] = $row;
                }
            }
            else{
                $arr = false;
            }
            
            return $arr;
        }
        
        /* log in Database with objects login data
            return is dbconnection or false if failed */
        private function login() {
            $db = new mysqli($this->hostname, $this->username, $this->password, $this->standardschema);
            if(!$db->errno) {
                return $db;
            }
            else {
                return false;
            }
        }
        
        /* close databaseconnection in parameter 
            only use after login<*/
        private function logout($db){
            $db->close();
        }
    }


?>