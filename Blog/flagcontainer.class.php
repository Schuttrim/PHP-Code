<?php

/*
Here we are able to save flags, which will be
used in view
*/
class flagcontainer {
    public $newarticle;
    public $useradministration;
    public $delete;
    public $edit;
    public $comment;
    
    public function __construct() {
        $this->newarticle = false;
        $this->useradministration = false;
        $this->delete = false;
        $this->edit = false;
        $this->comment = false;
    }
}

?>