<?php
if($index)
{
	function generate_link_by_current_get($type = "raw")
	{
		$nbr_get = count($_GET);

		$link = "index.php";

		for($i = 0 ; $i < $nbr_get ; $i++)
		{
			if($i == 0)
			{
				$link .= "?".key($_GET)."=".$_GET[key($_GET)];
			}
			else
			{
				switch($type)
				{
					case "raw":
						if($_GET[key($_GET)] != "")
						{
							$link .= "&amp;".key($_GET)."=".$_GET[key($_GET)];
						}
						else
						{
							$link .= "&amp;".key($_GET);
						}
						break;
					case "print":
						if($_GET[key($_GET)] != "")
						{
							$link .= "&".key($_GET)."=".$_GET[key($_GET)];
						}
						else
						{
							$link .= "&".key($_GET);
						}
						break;
				}
			}

			next($_GET);
		}

		reset($_GET);

		return $link;
	}

	function redirect($link)
	{
		global $js_wait_redirect_time;

		$return = "
		<script type='text/javascript'>
			<!--
			var obj = 'window.location.replace(\"".$link."\");';
			setTimeout(obj,".$js_wait_redirect_time.");
			// -->
		</script>";

		return $return;
	}
	
	// Enregistre l'evenement indiqué
	// Output :
	// 0 => Echec de l'ahout de l'evenement
	// 1 => Ajout de l'evenement réussi avec succès
	function log_event($site,$type,$details,$session)
	{
		global $bdd_general;

		$ins = $bdd_general->prepare("INSERT INTO `events` VALUES('',:site,:date,:type,:ip,:session,:details)");
		$ins->execute(array("site" => $site,
							"date" => time(),
							"type" => $type,
							"ip" => $_SERVER['REMOTE_ADDR'],
							"session" => $session,
							"details" => $details));

		if($ins->rowCount())
		{
			$flag = 1;
		}
		else
		{
			$flag = 0;
		}

		$ins->closeCursor();

		return $flag;
	}

	function imagethumb( $image_src , $image_dest = NULL , $max_size = 100, $expand = FALSE, $square = FALSE )
	{
		if( !file_exists($image_src) ) {return FALSE;}

		// Recupere les infos de l'image
		$fileinfo = getimagesize($image_src);
		if( !$fileinfo ) {return FALSE;}

		$width     = $fileinfo[0];
		$height    = $fileinfo[1];
		$type_mime = $fileinfo['mime'];
		$type      = str_replace('image/', '', $type_mime);

		if( !$expand && max($width, $height)<=$max_size && (!$square || ($square && $width==$height) ) )
		{
			// L'image est plus petite que max_size
			if($image_dest)
			{
				return copy($image_src, $image_dest);
			}
			else
			{
				header('Content-Type: '. $type_mime);
				return (boolean) readfile($image_src);
			}
		}

		// Calcule les nouvelles dimensions
		$ratio = $width / $height;

		if( $square )
		{
			$new_width = $new_height = $max_size;

			if( $ratio > 1 )
			{
				// Paysage
				$src_y = 0;
				$src_x = round( ($width - $height) / 2 );

				$src_w = $src_h = $height;
			}
			else
			{
				// Portrait
				$src_x = 0;
				$src_y = round( ($height - $width) / 2 );

				$src_w = $src_h = $width;
			}
		}
		else
		{
			$src_x = $src_y = 0;
			$src_w = $width;
			$src_h = $height;

			if ( $ratio > 1 )
			{
				// Paysage
				$new_width  = $max_size;
				$new_height = round( $max_size / $ratio );
			}
			else
			{
				// Portrait
				$new_height = $max_size;
				$new_width  = round( $max_size * $ratio );
			}
		}

		// Ouvre l'image originale
		$func = 'imagecreatefrom' . $type;
		if( !function_exists($func) ) {return FALSE;}

		$image_src = $func($image_src);
		$new_image = imagecreatetruecolor($new_width,$new_height);

		// Gestion de la transparence pour les png
		if( $type=='png' )
		{
			imagealphablending($new_image,false);
			if( function_exists('imagesavealpha') )
			{
				imagesavealpha($new_image,true);
			}
		}

		// Gestion de la transparence pour les gif
		elseif( $type=='gif' && imagecolortransparent($image_src)>=0 )
		{
			$transparent_index = imagecolortransparent($image_src);
			$transparent_color = imagecolorsforindex($image_src, $transparent_index);
			$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
			imagefill($new_image, 0, 0, $transparent_index);
			imagecolortransparent($new_image, $transparent_index);
		}

		// Redimensionnement de l'image
		imagecopyresampled(
			$new_image, $image_src,
			0, 0, $src_x, $src_y,
			$new_width, $new_height, $src_w, $src_h
		);

		// Enregistrement de l'image
		$func = 'image'. $type;
		if($image_dest)
		{
			$func($new_image, $image_dest);
		}
		else
		{
			header('Content-Type: '. $type_mime);
			$func($new_image);
		}

		// LibÃ©ration de la mÃ©moire
		imagedestroy($new_image); 

		return TRUE;
	}
	
	function frurandom($lenght)
	{
		$pr_bits = '';
		
		$fp = @fopen('/dev/urandom','rb');
		if ($fp !== FALSE) {
			$pr_bits .= @fread($fp,$lenght);
			@fclose($fp);
		}
		
		return $pr_bits;
	}
}
else
{
	include('error.php');
}