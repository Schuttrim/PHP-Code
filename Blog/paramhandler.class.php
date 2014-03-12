<?php

    require_once('permission.class.php');
    require_once('flagcontainer.class.php');
    
    // ACHTUNG noch nicht vor SQLINJECTIONS geschützt
    // SOME ACTIONS UNHANDLED
    
    /*
    This may handle all html Parameters
    */
    class paramhandler {
        private $db;
        
        public function  __construct($db) {
            $this->db = $db;
        }
        
        /*
        To be called to manage params
        */
        public function handleparams() {
            $this->handlelogin();
            $this->handlelogout();
            $this->handledelete();
            $this->handleedit();
            $this->handlecomment();
            $this->handlenewarticle();
            $this->handleuseradministration();
        }
        
        /*
        Handles newarticle Parameter
        */
        private function handlenewarticle() {
            if(isset($_POST['newarticle']) && isset($_SESSION['userid'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), null);
                if($userpermission->hasnewarticlepermission()) {
                    $GLOBALS['flags']->newarticle = true;
                }
            }
        }
        
        /*
        Handles useradministration Parameter
        */
        private function handleuseradministration() {
            if(isset($_POST['useradministration']) && isset($_SESSION['userid'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), null);
                if($userpermission->hasuseradminpermission()) {
                    $GLOBALS['flags']->useradministration = true;
                }
            }
        }
        
        /*
        Handles Delete Parameter
        */
        private function handledelete() {
            if(isset($_POST['delete']) && isset($_SESSION['userid']) && isset($_POST['id'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), $this->db->getarticlebyid($_POST['id']));
                if($userpermission->hasdeletepermission()) {
                    $GLOBALS['flags']->delete = true;
                }
            }
        }
        /*
        Handles Edit Parameter
        */
        private function handleedit() {
            if(isset($_POST['edit']) && isset($_SESSION['userid']) && isset($_POST['id'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), $this->db->getarticlebyid($_POST['id']));
                if($userpermission->haseditpermission()) {
                    $GLOBALS['flags']->edit = true;
                }
            }
        }
        
        /*
        Handles comment Parameter
        */
        private function handlecomment() {
            if(isset($_POST['comment']) && isset($_SESSION['userid']) && isset($_POST['id'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), $this->db->getarticlebyid($_POST['id']));
                if($userpermission->hascommentpermission()) {
                    $GLOBALS['flags']->comment = true;
                }
            }
        }
        
        
        /*
        Handles Login Parameters
        */
        private function handlelogin() {
            if (isset($_POST['login'])) {
                if(($id = $this->db->isvalidpwuser($_POST['user'], $_POST['pw'])) == true) {
                    $_SESSION['userid'] = $id;
                }
            }
        }
        
        /*
        Handles Logout parameters
        */
        private function handlelogout() {
            if (isset($_POST['logout'])) {
                $_SESSION = [];
                session_destroy();
            }
        }
    }
    
?>