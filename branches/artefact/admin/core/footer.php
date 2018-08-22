			</div>
		</div>
		
		<!-- Font Awesome -->
		<script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
		
		<!-- Popper JS Requit pour Bootstrap-->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
		
		<!-- Bootstrap Javascript -->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
		<!-- Core Javascript -->
		<script src="core/js/colonne.js"></script>
		<script src="core/js/tools.js"></script>
		<!-- Chargement Javascript des plugins si défini dans la config -->
		<?php
			foreach ($plugins as $plugin_name => $plugin_config)
			{
				if($plugin_config['js'])
				{
					echo "<!-- Chargement du Javascript du Plugin ".$plugin_name." -->";
					
					if(is_array($plugin_config['js']))
					{
						foreach($plugin_config['js'] as $url)
						{
							echo "<script src=".$url."></script>";
						}
					}
					else
					{
						echo "<script src=".$plugin_config['js']."></script>";
					}
				}
			}
		?>
		<!-- Appel Javascript des pages si existe -->
		<?php
			foreach($active_page as $page)
			{
				if(file_exists($_SESSION['root_path']."javascript/".$page.".js"))
				{
					echo "
					<!-- Chargement Javascript ".$page." -->
					<script src='".$site_url."javascript/".$page.".js'></script>";
				}
			}
		?>
	</body>
</html>