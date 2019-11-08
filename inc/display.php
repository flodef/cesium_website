<?php

function displayMenu ($menu, $path)
{
	echo '<ul>';
	foreach ($menu as $item)
	{
		echo '

		<li>';

			echo '

			<a href="'. parseURI($path . $item['uri']) .'">
				'. $item['label'] .'
			</a>';

			if (isset($item['submenu']))
			{
				displayMenu($item['submenu'], ($path . $item['uri']));
			}

			echo '
		</li>';
	}
	echo '</ul>';
}