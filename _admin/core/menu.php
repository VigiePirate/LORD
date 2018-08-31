<?php

foreach($menus as $type => $menu)
{
	if($menu['active'])
	{
		switch($menu['type'])
		{
			case "link":
				echo "
				<nav class='navbar navbar-light bg-lord fixed-".$type."'>
					<ul class='nav navbar-nav mx-auto'>
						<p style='margin-bottom:0px;'>".$menu['text']."</p>
					</ul>
				</nav>";
				break;
			case "menu":
				echo "
				<nav class='navbar navbar-expand-xl navbar-light bg-lord fixed-".$type."'>
				<button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbar".$type."' aria-controls='#navbar".$type."' aria-expanded='false' aria-label='Toggle navigation'>
					<span class='navbar-toggler-icon'></span>
				</button>";

				if(array_key_exists("brand", $menu))
				{
					echo "<a class='navbar-brand' href='index.php'>".$menu['brand']."</a>";
				}

				echo "<div class='collapse navbar-collapse' id='navbar".$type."'>";

				if(isset($menu['elements']))
				{
					echo "<ul class='navbar-nav mr-auto'>";
					
					foreach($menu['elements'] as $element)
					{
						if ($element['active'])
						{
							if(array_key_exists("submenu",$element))
							{
								if($element['name'] == $page)
								{
									echo "
									<li class='nav-item active dropdown'>
										<a href='#' data-toggle='dropdown' class='nav-link dropdown-toggle'>
											".$element['titre']." <b class='caret'></b>
										</a>
										<div class='dropdown-menu'>";
								}
								else
								{
									echo "
									<li class='nav-item dropdown'>
										<a href='#' data-toggle='dropdown' class='nav-link dropdown-toggle'>
											".$element['titre']." <b class='caret'></b>
										</a>
										<div class='dropdown-menu'>";
								}
								
								foreach($element['submenu'] as $submenu)
								{
									if($submenu['active'])
									{
										echo "<a class='dropdown-item' href='".$submenu['url']."'>".$submenu['titre']."</a>";
									}
								}
								
								echo "
									</div>
								</li>";
							}
							else
							{
								if($element['name'] == $page)
								{
									echo "
									<li class='nav-item active'>
										<a class='nav-link' href='".$element['url']."'>".$element['titre']."</a>
									</li>";
								}
								else
								{
									echo "
									<li class='nav-item'>
										<a class='nav-link' href='".$element['url']."'>".$element['titre']."</a>
									</li>";
								}
							}
						}
					}
					
					echo "</ul>";
				}

				if(isset($menu['elements_right']))
				{
					echo "<ul class='navbar-nav ml-auto'>";
					
					foreach($menu['elements_right'] as $element)
					{
						if ($element['active'])
						{
							if(isset($element['name']) && $element['name'] == $page)
							{
								echo "
								<li class='nav-item active'>
									<a class='nav-link' href='".$element['url']."'>".$element['titre']."</a>
								</li>";
							}
							else
							{
								echo "
								<li class='nav-item'>
									<a class='nav-link' href='".$element['url']."'>".$element['titre']."</a>
								</li>";
							}
						}
					}
					
					echo "</ul>";
				}

				echo "
					</div>
				</nav>";
				break;
		}
		/*switch($menu['type'])
		{
			
			case "menu":
				if(isset($menu['elements']))
				{
					echo "<ul class='nav navbar-nav'>";
					
					foreach($menu['elements'] as $element)
					{
						if ($element['active'])
						{
							if(array_key_exists("submenu",$element))
							{
								if($page == $element['name'])
								{
									echo "
									<li class='active'>
										<a href='#' class='nav-dropdown'>".$element['titre']."</a>
										<ul class='nav nav-second-level'>";
								}
								else
								{
									echo "
									<li>
										<a href='#' class='nav-dropdown'>".$element['titre']."</a>
										<ul class='nav nav-second-level collapse'>";
								}
								
								foreach($element['submenu'] as $submenu)
								{
									if($submenu['name'] == $section)
									{
										echo "<li class='active'><a href='".$submenu['url']."'>".$submenu['titre']."</a></li>";
									}
									else
									{
										echo "<li><a href='".$submenu['url']."'>".$submenu['titre']."</a></li>";
									}
								}

								echo "
									</ul>
								</li>";
							}
							else
							{
								if($page == $element['name'])
								{
									echo "<li class='active'><a href='".$element['url']."'>".$element['titre']."</a></li>";
								}
								else
								{
									echo "<li><a href='".$element['url']."'>".$element['titre']."</a></li>";
								}
							}
						}
					}
					
					echo "</ul>";
				}
				
				if(isset($menu['elements_right']))
				{
					echo "<ul class='nav navbar-nav navbar-right'>";
					
					foreach($menu['elements_right'] as $element)
					{
						echo "<li><a href='".$element['url']."'>".$element['titre']."</a></li>";
					}
					
					echo "</ul>";
				}
				
				
				echo "</nav>";
				break;
		}*/
	}
}

