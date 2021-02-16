<?php


//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

//$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];
$filaments = $GLOBALS['filaments'];
$filamentTypes = $GLOBALS['filamentTypes'];





//echo 'filaments: <br>' .  json_encode($filaments) . '<br>';

//echo json_encode($filaments);

?>

<div>
	<form action="index.php?c=order&a=configurator" method="POST">
		<label for="browser">Choose your filament from the list: <br> </label>
		<?php

		foreach ($filamentTypes as $type => $count) {
			echo"$type :";
			echo"
				<input list=\"filaments$type\" name=\"filament\" placeholder=\"placeholder\" > <!-- name ist der key, aus dem php den Wert erhält -->
					<datalist id=\"filaments$type\" > <!-- id muss selben key wie list oben drüber haben -->
				";

			foreach ($filaments as $filament) {

				if ($filament['type'] == $type) {
					echo '<option value="' . $filament['color'] . '">';

				}
			}

			echo '
					</datalist>
				<input type="submit">
				';
		}

		?>

	</form>
</div>