<?php

	function bdd()
		{
			try
			{
				$pdo_options[PDO :: ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
				$bdd = new PDO('mysql:host=localhost;dbname=sonatrach','root','');
			

			}
			catch(PDOException $e)
			{
				die("ERR : ".$e->getMessage());
			}
			return $bdd;
			
		}
	
		function add_user($user,$info,$db)
		{
			//verification l'existance d'utilisateur
			$sql ="SELECT * FROM `utilisateur` WHERE user='$user'";
			$r= $db->query($sql);
			if($row = $r->fetch())
			{
				echo"l'Utilisateur exite deja";
			}
			else 
			{ //adduser
				//hashing the password bcrypt est une fonction de hachage créée par Niels Provos et David Mazières. Elle est basée ... L'algorithme dépend fortement de l'établissement des clefs de la méthode « Eksblowfish »

				$query ="INSERT INTO `utilisateur`(`id_user`, `nom`, `prenom`, `numTel`, `email`, `role`, `user`, `pass`) VALUES ('','".$info['nom']."','".$info['prenom']."','".$info['numTel']."','".$info['email']."','".$info['Role']."','".$info['user']."','".$info['pass']."')";
					$res= $db->exec($query) or die('Erreur SQL !<br>'.$query.'<br>'.$db->errorInfo());
					die("inscription terminé<a href='login.php'>Connectez</a>-vous");
					return $res;
			} 
		}
		function search_user($info,$db)
		{
			$sql="SELECT * FROM utilisateur 
      					WHERE id_user='$info' or nom='$info' or prenom='$info' or email='$info' or numTel='$info' or role='$info' or user='$info'";
      					$sql="SELECT * FROM utilisateur";
	      		$req = $db->prepare($sql);
				$req->execute();
		if($donnees = $req->fetch()){
			echo"<table class='table table-hover'>
				  <thead>
				    <tr>
				      <th scope='col'>ID <i class='fa-pencil' title='Edit'></i></th>
				      <th scope='col'>Nom </th>
				      <th scope='col'>Prenom</th>
				      <th scope='col'>Email</th>
				      <th scope='col'>Num de Tel</th>
				      <th scope='col'>Role</th>
				      <th scope='col'>User</th>
				      <th scope='col'>Modifier</th>
				      <th scope='col'>supprimer</th>
				    </tr>
				  </thead>
				  <tbody>";

			while($donnes = $req->fetch())
			{
				$id=$donnes['id_user'];
				echo"
			<tr>
		          <td>".$donnes['id_user']."</td>
		          <td>".$donnes['nom']."</td>
		          <td>".$donnes['prenom']."</td>
		          <td>".$donnes['numTel']."</td>
		          <td>".$donnes['email']."</td>
		          <td>".$donnes['role']."</td>
		          <td>".$donnes['user']."</td>
		          <td>
		          		<a href='ModifierNote.php?id=$id' class='btn btn-warning'>Modifier</a>
		          </td>
		         	<td> <a href='delete.php?id=$id' onclick='return confirm(\"Etes vous sure  de Supprimer?\");'
      			class='btn btn-danger'>Supprimer</a>    
      			   </td> 
        			
        	</tr>";}
        echo" </tbody>
			</table>";}
        	else{
      echo '<h4>aucun résultat trouvé</h4>';
       $reponse->closeCursor();
    }
   
		}
	
		function getRole($user,$db)
		{
			$sql="SELECT role FROM utilisateur 
      					WHERE user='$user'";
      		$req = $db->prepare($sql);
			$req->execute();
			$array = $req->fetchALL();
		    return $array[0]['role'];
		}
		function verif_user($db,$user,$pass)
		{
						
      		$sql="SELECT pass FROM utilisateur 
      					WHERE user='$user'";
      		$req = $db->prepare($sql);
			$req->execute();
			$array = $req->fetchALL();
			$passR = $array[0]['pass'];
		if(password_verify ( $pass , $passR ))
			{
      		$_SESSION['user'] = $user;
      		$_SESSION['pass'] = $pass; 
      			
      						header('location:http://localhost/db/indexe.php');
      		exit();
      		
	      	}
	      	else
	      	{
	            session_destroy();
	      		echo" <p style='color:red'>Utilisateur ou mot de passe Incorrect</p> ";
	      	}	
		}

		function get_Users($user,$db) 
    	{
    		if(getRole($user,$db)=="admin")
    		{
    			$sql="SELECT * FROM utilisateur where `id_user` != '1'";
	      		$req = $db->prepare($sql);
				$req->execute();
				
				   

			while($donnes = $req->fetch())
			{
				$id=$donnes['id_user'];
				echo"
			<tr>
		          <td>".$donnes['id_user']."</td>
		          <td>".$donnes['nom']."</td>
		          <td>".$donnes['prenom']."</td>
		          <td>".$donnes['numTel']."</td>
		          <td>".$donnes['email']."</td>
		          <td>".$donnes['role']."</td>
		          <td>".$donnes['user']."</td>
		          <td>
		          		<a style='color: orange;text-align: center' href='ModifierUser.php?id=$id' >
			          		<svg width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-pencil-square' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
							  <path d='M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z'/>
							  <path fill-rule='evenodd' d='M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z'/>
							</svg>
						</a>
		          </td>
		         	<td> <a style='color: red;text-align: center' href='DeleteUser.php?id=$id' onclick='return confirm(\"Etes vous sure  de Supprimer?\");'>
      						<svg width='2em' height='2em' viewBox='0 0 16 16' class='bi bi-person-dash-fill' fill='currentColor' xmlns='http://www.w3.org/2000/svg'>
                                <path fill-rule='evenodd' d='M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm5-.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5z'/>
                        	 </svg>
                           </a>    
      			   </td> 
        			
        	</tr>";
        	}

    		}
    		    	}
    	function getUserById($id, $db)
		{
			$sql = "SELECT * from utilisateur WHERE id_user='$id'";

			$r= $db->query($sql);

			if($row = $r->fetch())
			{
				return $row;
			}
			else
			{
				echo "Not found";
			}
		}
		function Modifier_user($db)
		{
			if(isset($_REQUEST['id']) && isset($_REQUEST['nom']) && isset($_REQUEST['prenom']) && isset($_REQUEST['email']) && isset($_REQUEST['numTel']) && isset($_REQUEST['role'])&& isset($_REQUEST['pass']))
			{
				$id_user	 = 	$_REQUEST['id'];//sauvgarder la valeur ID d'article dans une variable pui on l'envoyer avec le lien
				$nom 	 = 	$_REQUEST['nom'];
				$prenom	 = 	$_REQUEST['prenom']; 	
	      		$email 	 =  $_REQUEST['email'];
	      		$numTel 	 = 	$_REQUEST['numTel'];
				$role	 = 	$_REQUEST['role']; 	
	      		$pass 	 =  password_hash($_REQUEST['pass'], PASSWORD_DEFAULT);//hache le password

				$query = "UPDATE `utilisateur` SET `nom`='$nom',`prenom`='$prenom',`numTel`='$numTel',`email`='$email',`role`= '$role',`pass`='$pass' WHERE `id_user`= '$id_user' ";
				$db->exec($query);
				
			}
		}
    	function delete_User($bdd,$idU)
    	{
    		
    		$req=$bdd->prepare('DELETE FROM utilisateur WHERE id_user =:idp');
    		$req->execute(array('idp'=>$idU)) or die(print_r($bdd->errorInfo()));
    		//$data=getUserById($idU,bdd());
    		//$req=$bdd->prepare('DELETE FROM projet WHERE user =:user');

    		//$req->execute(array('user'=>$data['user'])) or die(print_r($bdd->errorInfo()));
    	}
 
		
		
		function add_note($info,$db,$user)
		{
			$date= date('y-m-d');
			$query ="INSERT INTO `note`(`id_note`, `titreN`, `ContenuN`, `user`, `dateN`) VALUES ('','".$info['titreN']."','".$info['contenuN']."','".$user."','".$date."')";
					$res= $db->exec($query) or die('Erreur SQL !<br>'.$query.'<br>'.$db->errorInfo());
					die("la Note a été bien ajouter <a href='ConsulterNote.php'> voire </a> mes notes");
					return $res;
		}
		function get_note($user,$db)
		{

			$sql="SELECT * FROM note 
      					WHERE user='$user'";
      		$req = $db->prepare($sql);
			$req->execute();
			while($donnes = $req->fetch())
			{
				echo"
			<tr>
		          <td>".$donnes['titreN']."</td>
		          <td>".$donnes['dateN']."</td>
		          <td>".$donnes['ContenuN']."</td>";
		          $id=$donnes['id_note'];
		          echo"
		          <td>
		          		<a href='ModifierNote.php?id=$id' class='btn btn-warning'>Modifier</a>
		          </td>
		         	<td> <a href='delete.php?id=$id' onclick='return confirm(\"Etes vous sure  de Supprimer?\");'
      			class='btn btn-danger'>Supprimer</a>    
      			   </td> 
        			
        	</tr>";
        	}
        	
		}
		function get_note_card($user,$db)
		{
			$sql="SELECT * FROM note 
      					WHERE user='$user'";
      		$req = $db->prepare($sql);
			$req->execute();
			echo"
				<div class='d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>
      <h1 class='h2'>Voici Quelque Notes : </h1>
    </div>
			<style>
					.card{
						display:inline-flex;
					}
			</style>";
			while($donnes = $req->fetch())  {echo"

		    <div class= 'card' style='width: 18rem; margin-right: 1rem'>
		    <div class='card-body'>
		    <h5 class='card-title'>".$donnes['titreN']."</h5>
		    <h6 class='card-subtitle mb-2 text-muted'>".$donnes['dateN']."</h6>
		    <p class='card-text'>".$donnes['ContenuN']."</p>
		    </div>
		    </div>";
			}
     
    	}

    	
		
		function delete_note($id,$db)
		{
			$query= $db->prepare("DELETE FROM `note` WHERE id_note= '$id'");
				$query->execute();
		}
		
		function getNoteById($id, $db)
		{
			$sql = "SELECT * from note WHERE id_note='$id'";

			$r= $db->query($sql);

			if($row = $r->fetch())
			{
				return $row;
			}
			else
			{
				echo "Not found";
			}
		}

		function Modifier_note($db)
		{
			if(isset($_REQUEST['id']) && isset($_REQUEST['titre']) && isset($_REQUEST['contenu']) && isset($_REQUEST['date']))
			{
				$id_note	 = 	$_REQUEST['id'];//sauvgarder la valeur ID d'article dans une variable pui on l'envoyer avec le lien
				$titreN	 	 = 	$_REQUEST['titre'];
				$contenuN	 = 	$_REQUEST['contenu']; 	
	      		$dateN  		 =  $_REQUEST['date'];

				$query = "UPDATE `note` SET `titreN`='$titreN',`ContenuN`='$contenuN',`dateN`='$dateN' WHERE `id_note`='$id_note' ";
				$db->exec($query);
				
			}
		}
		function redirect()
		{
			
		}
		

		
?>