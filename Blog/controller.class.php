<?php
    require_once('database.class.php');
    require_once('view.class.php');
    require_once('datacontainer.class.php');
    require_once('paramhandler.class.php');
    
    
    /* 
    Controller to manage main
    Website Stuff
    */
    class maincontroller{
        private $db;
        private $page;
        private $handler;
        private $user;
        
        
        public function __construct(){
            $this->db = new database('localhost', 'root', '', 'Blog');
            $this->page = new page();
            $this->handler = new paramhandler($this->db);
            
            $this->startrendering();
        }
        
        /* Starts whole rendering of Website */
        private function startrendering() {
            $this->handler->handleparams();
            
            // get user
            if(isset($_SESSION['userid'])) {
                $this->user = $this->db->getuser($_SESSION['userid']);
            }
            else {
                $this->user = null;
            }
            
            // loginboxrendering
            $GLOBALS['data']->setloginbox($this->page->getloginbox($this->user));
            
            // usercommandrendering
            $GLOBALS['data']->setusercmd($this->page->getusercmd($this->user));
            
            // blogpostrendering
            $GLOBALS['data']->setbody($this->page->getbody($this->db->getarticles(), $this->user));
            
            
        }
        
    }
    
    
?>