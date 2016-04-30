<?php 
include_once 'module/BackEnd/create.backend.php';

if ($role !== '6'){echo 'zugriff nicht erlaubt';}
else{?>
<div class="BackEnd">
	<div class="BEL">
<?php 
		$nd= new menu();
		$nd->show();
		br();
		switch ($selector)
		{
			case 'css':
				$css1 = scandir('html/css/');
				foreach ($css1 as $k){
					if ($k !== "." && $k !== "..")
					{
						echo '<form action="'.$target.'" method="POST">';
						echo '<input type="hidden" name="selector" value="css" />';
						echo '<input type="submit" name="select" value="'.$k.'" />';
						echo '</form>';
					}
				}
				break;
			case 'Module':
				get_plugin_files();
				foreach ($plugins as $k){
					echo '<form action="'.$target.'" method="POST">';
					echo '<input type="hidden" name="selector" value="Module" />';
					echo '<input type="submit" name="select" value="'.$k.'" />';
					echo '</form>';
				}
				break;
			case 'Navigation':
				break;
		}
			
?>
	</div>
	<div class="BEV">
		<div class="BEM">
			<?php 
			echo '<input type="textarea" name="change" value="'.$select.'" />';
			?>
		</div>
		<div class="BER">
		
		</div>
	</div>

</div>
<?php }  // else zu
		?>
