<?php
    require_once('permission.class.php');
    require_once('flagcontainer.class.php');

    class page{
        
        public function __construct() {
        
        }
        
        public function getusercmd($user){
            $retval = '';
            $userpermission = new permission($user, null);
            if(!empty($user)) {
                $retval = $retval . '
                <form action="index.php" method="POST">';
                if($userpermission->hasnewarticlepermission()){
                    $retval = $retval . '
                    <input type="submit" name="newarticle" value="Neuer Artikel" />';
                }
                if($userpermission->hasuseradminpermission()){
                    $retval = $retval . '
                    <input type="submit" name="useradministration" value="Benutzer Verwalten" />';
                }
                
                $retval = $retval . '
                </form>';
            }
            return $retval;
            
        }
        
        public function getbody($bodys, $user) {
            $retval = '';
            
            foreach($bodys as $body) {
                $articlepermission = new permission($user, $body);
                $retval = $retval . '
                <div class="article">
                    <a href="index.php?article=' . $body->id . '">
                        <div class="header">
                            <p class="title">' . $body->topic . '</p>
                            <p class="author">' . $body->nickname . '</p>
                            <p class="date">' . $body->creationdate . '</p>
                        </div>
                    </a>
                    <div style="clear:both"> </div>
                    <div class="content">' 
                        . $body->content . '
                        <div class="buttons">
                            <form action="index.php" method="POST">
                                <input type="hidden" value="'. $body->id .'" name="id" />';
                                // Registrierte benutzer können kommentieren
                                if($articlepermission->hascommentpermission()) {
                                    $retval = $retval . '
                                    <input type="submit" name="comment" value="Kommentieren" />';
                                }
                                // falls er delete rechte hat
                                if($articlepermission->haseditpermission()) {
                                    $retval = $retval . '
                                    <input type="submit" name="edit" value="Editieren" />';
                                } 
                                // falls er edit rechte hat
                                if($articlepermission->hasdeletepermission()) {
                                    $retval = $retval . '
                                    <input type="submit" name="delete" value="Löschen" />';
                                }
                                $retval = $retval . '                                    
                            </form>
                        </div>
                    </div>
                    <div style="clear:both"> </div>
                    <!-- insert Comments -->
                </div>
                <div style="clear:both"> </div>';
            }
            return $retval;
        }
        
        public function getloginbox($user) {
            $retval = '';
            if(!count($user) == 1) {
                $retval = '
                <form action="index.php" method="POST">
                    <label for="user">Benutzername: </label>
                    <input name="user" type="text"/>
                    <label for="pw">Passwort: </label>
                    <input name="pw" type="password"/>
                    <input name="login" type="submit" value="Einloggen" />
                </form> ';
            }
            else { 
                $retval = '
                <form action="index.php" method="POST">
                    <label for="logout">' . $user->Name . ' ' . $user->Vorname . ' angemeldet </label>
                    <input name="logout" type="submit" value="Ausloggen" />
                </form> ';
            }
            return $retval;
        }
        
    }
    
?>




