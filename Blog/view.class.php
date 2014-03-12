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
				if($GLOBALS['flags']->newarticle || $GLOBALS['flags']->useradministration || $GLOBALS['flags']->edit) {
                    $retval = $retval . '
                    <input type="submit" name="backtonormal" value="Zurück" />';
				}
                if($userpermission->hasnewarticlepermission() && $GLOBALS['flags']->newarticle == false){
                    $retval = $retval . '
                    <input type="submit" name="newarticle" value="Neuer Artikel" />';
                }
                if($userpermission->hasuseradminpermission() && $GLOBALS['flags']->useradministration == false){
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
			
			// create body depending on flags
			switch(true){
				case $GLOBALS['flags']->newarticle:
					$retval = $this->newarticleform($retval);
					break;
				case is_string($GLOBALS['flags']->edit):
					$retval = $this->neweditform($retval, $bodys, $GLOBALS['flags']->edit);
					break;
				
				default: // no body affecting flag set
					$retval = $this->articlelist($retval, $bodys, $user);
				
			} // end of switch
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
		
		
		/* adds edit formular to current $retval string */
		private function neweditform($retval, $articles, $id) {
			if($article = $this->getarticlebyid($articles, $id)) {
			$retval = $retval . '
			<div class="editarticle">
				<form action="index.php" method="POST">
					<div class="inputs">
						<input type="hidden" name="id" value="' . $article->id . '" />
						<div class="element"><input type="text" name="title" value="' . $article->topic . '"/><div>
						<div class="element"><textarea name="content" cols="100" rows"50">' . $article->content . '</textarea></div>
					</div>
					<div class="buttons">
						<div class="element"><input type="submit" name="editsent" value="Absenden" /></div>
					</div>
				</form>
			</div>';
			}			
			
			return $retval;
		}
		
		/* adds new article formular to current $retval string */
		private function newarticleform($retval) {
			$retval = $retval . '
			<div class="newarticle">
				<form action="index.php" method="POST">
					<div class="inputs">
						<div class="element"><input type="text" name="title" /><div>
						<div class="element"><textarea name="content" cols="100" rows"50"></textarea></div>
					</div>
					<div class="buttons">
						<div class="element"><input type="submit" name="newarticlesent" value="Absenden" /></div>
					</div>
					
				</form>
			</div>';
			return $retval;
		}
		
		/* adds article list to current $retval string */
		private function articlelist($retval, $bodys, $user) {
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
		
		/* Finds article in articles[] by selected id 
			Returns article or false */
		private function getarticlebyid($articles, $id) {
			$retval = false;
			foreach ($articles as $article) {
				if($article->id == $id) {
					$retval = $article;
					break;
				}
			}
			return $retval;
		}
        
    }
    
?>




