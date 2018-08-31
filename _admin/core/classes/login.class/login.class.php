<?php

class Login{
	private $_bdd;
	private $_cookie_lifespan;
	
	public $User;
	
	public function __construct($bdd,$cookie_lifespan,$User){
		$this->_bdd = $bdd;
		$this->_cookie_lifespan = $cookie_lifespan;
		$this->User = $User;
	}
	
	public function checkCookie()
	{
		if(isset($_COOKIE['token']))
		{
			echo "<!--It is a Cookie (@o@)-->";
			
			$cookie = json_decode($_COOKIE['token']);
			
			$flag = TRUE;
			
			foreach($cookie as $row)
			{
				if(!ctype_alnum($row))
				{
					$flag = FALSE;
				}
			}
			
			if($flag)
			{
				echo "<!-- True cookie (/◕ヮ◕)/ -->";
				
				$req = $this->_bdd->prepare("SELECT * FROM `users_tokens` WHERE `token` = :token");
				$req->execute(array("token" => $cookie[1]));
				
				if($req->rowCount())
				{
					$donnees = $req->fetch();
					
					if($cookie[0] == hash('sha256',$_SESSION['ip']))
					{
						if($donnees['date_expiration'] > time())
						{
							echo "<!-- Granted Cookie (·ω·) -->";

							$this->User->connect = TRUE;

							$this->storeUserInfos($donnees['id_membre'],TRUE,$cookie[1]);

							$this->updateCookies();
						}
						else
						{
							echo "<!-- Expired Cookie (´；ω；`) -->";
							
							$this->logout();
						}
					}
					else
					{
						echo "<!-- Stolen Cookie (＃ﾟДﾟ) -->";
					}
				}
				else
				{
					echo "<!-- False Cookie (´；ω；`) -->";
				}
				
				$req->closeCursor();
			}
			else
			{
				echo "<!-- False cookie (；一_一) -->";
			}
		}
		else
		{
			echo "<!--Cookie is a lie (T_T)-->";
		}
	}
	
	public function connect($email,$password)
	{
		// Vérification paire email et mot de passe
		$req = $this->_bdd->query("
		SELECT u.id_membre id_membre, u.pseudo pseudo, u.email email, u.mdp mdp, u.level level, n.prenom prenom, n.nom nom
		FROM `users` u
		LEFT JOIN `users_noms` n ON u.id_membre = n.id_membre");

		$connect = 0;

		while($donnees = $req->fetch())
		{
			if((md5($password) == $donnees['mdp']) AND ($email == $donnees['email']))
			{
				if($donnees['level'] == 'staff' OR $donnees['level'] == 'admin')
				{
					$connect++;

					$id			= $donnees['id_membre'];
					$pseudo		= $donnees['pseudo'];
					$nom		= $donnees['nom'];
					$prenom		= $donnees['prenom'];
					$email		= $donnees['email'];
					$level		= $donnees['level'];

					if(isset($_POST['memco']) AND $_POST['memco'] == "Oui")
					{
						$memco = TRUE;
					}
				}
				else
				{
					$unautorized = TRUE;
				}
			}
		}

		if($connect == 0)
		{
			if(isset($unautorized) AND $unautorized == TRUE)
			{
				echo "
				<div class='row'>
					<div class='col-lg-12 text-center alert alert-block alert-danger'>
						<p>Vous n'êtes pas administrateur et n'avez donc pas l'autorisation d'accèder à cette partie du site.</p>
					</div>
				</div>";
			}
			else
			{
				echo "
				<div class='row'>
					<div class='col-lg-12 text-center alert alert-block alert-danger'>
						<p>Identifiant ou mot de passe incorrect.</p>
					</div>
				</div>";
			}
			
			$this->printLoginForm();
		}
		else if($connect == 1)
		{
			// A activer par la suite
			//if(!log_event($sous_domaine_actif, 'login_success', "Hash utilisé ".md5($_POST['password']),$_POST['identifiant']))
			//{
			//	echo "
			//	<div class='row'>
			//		<div class='col-lg-12 text-center alert alert-block alert-danger'>
			//			<p>Impossible de logger l'evenement. Merci de prévenir un Administrateur.</p>
			//		</div>
			//	</div>";
			//}

			echo "
			<div class='row'>
				<div class='col-lg-12 text-center alert alert-block alert-success'>
					<p>Connexion réussie</p>";

			$this->User->connect	= 1;
			$this->User->id			= $id;
			$this->User->level		= $level;
			$this->User->pseudo		= $pseudo;
			$this->User->username	= $prenom." ".$nom;
			$this->User->memco		= $memco;
			$this->User->token		= bin2hex(frurandom(64));

			echo "
					<p>Bienvenue ".$pseudo."</p>
				</div>
			</div>";

			$link = generate_link_by_current_get("print");
			
			if($this->User->memco)
			{
				$this->createCookie();
			}

			echo redirect($link);
		}
		else
		{
			echo "<p>Un erreur grave s'est produite</p>";
		}

		$req->closeCursor();
	}
	
	private function createCookie()
	{
		if(!is_null($this->User->token))
		{
			echo "<!-- Cooking Cookie (●＾o＾●) -->";
			
			$expiration = time() + $this->_cookie_lifespan;
			
			$ins = $this->_bdd->prepare("INSERT INTO `users_tokens` VALUE(:id_membre,:token,:date_crea,:date_expiration)");
			$ins->execute(array(
				"id_membre"			=> $this->User->id,
				"token"				=> $this->User->token,
				"date_crea"			=> time(),
				"date_expiration"	=> $expiration
			));
			
			if($ins->rowCount())
			{
				$this->setCookies($expiration);
			}
			else
			{
				error_log("Echec de création de l'entrée Token");
			}
			
			$ins->closeCursor();
		}
	}
	
	public function logout()
	{
		$logout = FALSE;
		
		if(isset($_COOKIE['token']))
		{
			$cookie = json_decode($_COOKIE['token']);
			
			$flag = TRUE;
			
			foreach($cookie as $row)
			{
				if(!ctype_alnum($row))
				{
					$flag = FALSE;
				}
			}
			
			if($flag)
			{
				$del = $this->_bdd->prepare("DELETE FROM `users_tokens` WHERE `token` = :token");
				$del->execute(array("token" => $cookie[1]));
				
				if($del->rowCount())
				{
					$this->setCookies(NULL);
					
					$logout = TRUE;
				}
				
				$del->closeCursor();
			}
		}
		else
		{
			$logout = TRUE;
		}
		
		return $logout;
	}
	
	public function printLoginForm()
	{
		echo "
		<form class='form-signin' method='post' action='".generate_link_by_current_get("raw")."'>
			<h2 class='form-signin-heading'>Accès restreint</h2>
			<label for='email' class='sr-only'>E-Mail</label>
			<input type='text' id='email' name='email' class='form-control' placeholder='E-Mail' required autofocus>
			<label for='password' class='sr-only'>Password</label>
			<input type='password' id='password' name='password' class='form-control' placeholder='Password' required>
			<div class='form-signin-switch'>
				Maintenir la connexion
				<div class='material-switch pull-right'>
					<input id='memco' name='memco' type='checkbox' value='Oui' />
					<label for='memco' class='label-primary'></label>
				</div>
			</div>
			<button class='btn btn-lg btn-primary btn-block' type='submit'>Connexion</button>
		</form>";
	}
	
	private function setCookies($expiration)
	{
		if(is_null($expiration))
		{
			$token = NULL;
			$expiration = time() - 3600;
		}
		else
		{
			$token = json_encode(array(hash('sha256',$_SESSION['ip']),$this->User->token));
		}
		
		setcookie('token',$token,$expiration,null,null,DOMAIN_ROOT,true);
	}
	
	private function storeUserInfos($id_membre,$memco = FALSE,$token = NULL)
	{
		$req = $this->_bdd->prepare("
		SELECT u.id_membre id_membre, u.pseudo pseudo, u.email email, u.mdp mdp, u.level level, n.prenom prenom, n.nom nom
		FROM `users` u
		LEFT JOIN `users_noms` n ON u.id_membre = n.id_membre
		WHERE u.id_membre = :id_membre");
		$req->execute(array("id_membre" => $id_membre));
		
		if($req->rowCount())
		{
			$donnees = $req->fetch();
			
			$this->User->id			= $id_membre;
			$this->User->level		= $donnees['level'];
			$this->User->nom		= $donnees['nom'];
			$this->User->memco		= $memco;
			$this->User->pseudo		= $donnees['pseudo'];
			$this->User->prenom		= $donnees['prenom'];
			$this->User->token		= $token;
			$this->User->username	= $donnees['prenom']." ".$donnees['nom'];
		}
		else
		{
			echo "<!-- A ghost (((( ；ﾟДﾟ))) -->";
		}
		
		$req->closeCursor();
	}
	
	public function updateCookies()
	{
		echo "<!-- Refreshing Cookie (●＾o＾●) -->";
		if(!is_null($this->User->token))
		{
			$expiration = time() + $this->_cookie_lifespan;
					
			$upt = $this->_bdd->prepare("UPDATE `users_tokens` SET `date_expiration` = :date_expiration");
			$upt->execute(array("date_expiration" => $expiration));
			
			if($upt->rowCount())
			{
				$this->setCookies($expiration);
			}
			else
			{
				$this->setCookies(NULL);
			}
			
			$upt->closeCursor();
		}
	}
}



