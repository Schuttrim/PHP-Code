<?php

    require_once('permission.class.php');
    require_once('flagcontainer.class.php');
    
    // ATTENTION SQLINJECTIOINS are not disabled
	// Special regard in functions handlenewarticlesent, -login, -newusersent, -editsent, -[every field thats going to get inserted in db]
	// TODO: make validation class which checks for SQL and HTML injections --> securitycheck
    
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
            $this->handlenewarticlesent();
            $this->handleeditsent();
        }
		
		/*
		Handles editsent parameter
		*/
        private function handleeditsent() {
			if(isset($_POST['editsent']) && isset($_SESSION['userid']) && isset($_POST['id'])){
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), $this->db->getarticlebyid($_POST['id']));
				if($userpermission->haseditpermission()) {
					// insert security check here
					if(!empty($_POST['title']) && !empty($_POST['content'])) {
						$this->db->editarticle($_POST['id'], $_POST['title'], $_POST['content']);
					}
				}
			}
		}
		/*
		Handles newarticlesent Parameter
		*/
		private function handlenewarticlesent() {
            if(isset($_POST['newarticlesent']) && isset($_SESSION['userid'])) {
                $userpermission = new permission($this->db->getuser($_SESSION['userid']), null);
                if($userpermission->hasnewarticlepermission()) {
					// insert security check here
					if(!empty($_POST['title']) && !empty($_POST['content'])) {
						$this->db->newinsertarticle($_POST['title'], $_POST['content'], $_SESSION['userid']);
					}
				}
			}
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
                    $GLOBALS['flags']->edit = $_POST['id'];
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
				// insert security check here
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