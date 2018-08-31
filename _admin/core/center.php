<?php
	if(in_array($page,$active_page))
	{
		include ($root_path."pages/".$page.".php");
	}
	else
	{
		echo "Page inactive ou inconnue";
	}