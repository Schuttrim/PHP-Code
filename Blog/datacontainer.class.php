<?php
    /* Container to save Generated htmlcode */
    class prepareddata {
        private $header;
        private $body;
        private $loginbox;
        private $usercmd;
        
        
        public function getloginbox() {
            return $this->loginbox;
        }
        public function setloginbox($value) {
            $this->loginbox = $value;
        }
        
        public function getheader() {
            return $this->header;
        }
        public function setheader($value) {
            $this->header = $value;
        }
        
        public function getbody() {
            return $this->body;
        }
        public function setbody($value) {
            $this->body = $value;
        }
        
        public function getusercmd() {
            return $this->usercmd;
        }
        public function setusercmd($value) {
            $this->usercmd = $value;
        }
    }

?>