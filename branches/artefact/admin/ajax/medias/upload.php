<?php
// Démarrage du moteur de session
session_start();

header('Content-Type: application/json');

require_once($_SESSION['root_path']."core/classes/lordrat.class/lordrat.api.config.php");
require_once($_SESSION['root_path']."core/classes/lordrat.class/lordrat.api.class.php");
require_once($_SESSION['root_path']."core/classes/user.class/user.class.php");

$User = unserialize($_SESSION['login']);
$Lord = new LORDRAT_API(LORDRAT_API_APP,LORDRAT_API_KEY,LORDRAT_API_URL,LORDRAT_AGENT);

if(isset($User->connect) AND $User->connect)
{
	$index = TRUE;

	require_once($_SESSION['root_path'].'core/config.php');
	require_once($_SESSION['root_path'].'core/co_db.php');
	
	if(isset($_FILES["myfile"]))
	{
		$ret = array();

		//	This is for custom errors;	
		/*	$custom_error['jquery-upload-file-error']="File already exists";
			echo json_encode($custom_error);
			die();
		*/
		$error =$_FILES["myfile"]["error"];
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if(!is_array($_FILES["myfile"]["name"])) //single file
		{
			error_log("Ajout d'un fichier seul");
			$fileName = $_FILES["myfile"]["name"];
			$fileArray = explode('.',$fileName);
			$extension = end($fileArray);
			$fileSize = $_FILES["myfile"]["size"];
			
			// Génération d'un nom unique pour stocker le fichier
			$storeName = md5($fileName)."_".time().".".$extension;
			
			// Si on a réussi à le déplacer à destination avec succès
			if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$_SESSION['medias_path'].$storeName))
			{
				error_log("Fichier ".$fileName." deplace : ".$_SESSION['medias_path'].$storeName);

				// Ajout Fichier dans BDD
				$result = $Lord->addMedia(array(
					"fichier"	=> $storeName,
					"nom"		=> substr ($fileName,0,strlen($fileName) -strlen ($extension)-1),
					"auteur"	=> $User->id,
					"meta"		=> json_encode(array(
							"size"		=> $fileSize
						))
				))->response->datas;

				error_log("Insertion DB : ".json_encode($result));

				if($result == "success")
				{
					$ret[]= $fileName;
				}
				else
				{
					unlink($_SESSION['medias_path'].$fileName);
					$custom_error['jquery-upload-file-error']=$result->error;
					echo json_encode($custom_error);
					die();
				}
			}
			else
			{
				$custom_error['jquery-upload-file-error']="Impossible de déplacer le fichier dans le dossier de destination";
				echo json_encode($custom_error);
				die();
			}
		}
		else  //Multiple files, file[]
		{
			$fileCount = count($_FILES["myfile"]["name"]);
			for($i=0; $i < $fileCount; $i++)
			{
				$fileName = $_FILES["myfile"]["name"][$i];
				$fileArray = explode('.',$fileName);
				$extension = end($fileArray);
				$fileSize = $_FILES["myfile"]["size"][$i];

				// Génération d'un nom unique pour stocker le fichier
				$storeName = md5($fileName)."_".time().".".$extension;

				// Si on a réussi à le déplacer à destination avec succès
				if(move_uploaded_file($_FILES["myfile"]["tmp_name"],$_SESSION['medias_path'].$storeName))
				{
					error_log("Fichier ".$fileName." deplace : ".$_SESSION['medias_path'].$storeName);

					// Ajout Fichier dans BDD
					$result = $Lord->addMedia(array(
						"fichier"	=> $storeName,
						"nom"		=> substr ($fileName,0,strlen($fileName) -strlen ($extension)-1),
						"auteur"	=> $User->id,
						"meta"		=> json_encode(array(
								"size"		=> $fileSize
							))
					))->response->datas;

					error_log("Insertion DB : ".json_encode($result));

					if($result == "success")
					{
						$ret[]= $fileName;
					}
					else
					{
						unlink($_SESSION['medias_path'].$fileName);
						$custom_error['jquery-upload-file-error']=$result->error;
						echo json_encode($custom_error);
						die();
					}
				}
				else
				{
					$custom_error['jquery-upload-file-error']="Impossible de déplacer le fichier dans le dossier de destination";
					echo json_encode($custom_error);
					die();
				}
			}

		}
		echo json_encode($ret);
	}
}
else
{
	$custom_error['jquery-upload-file-error']="Accès non autorisé";
	echo json_encode($custom_error);
	die();
}