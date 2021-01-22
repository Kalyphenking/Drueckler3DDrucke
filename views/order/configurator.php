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

<!--<model-viewer src="--><?//=ROOTPATH. 'Prusa_Slicer/uploads/TopfdeckelTeil.glb'?><!--" style="height: 500px; width: 50%" alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>-->

<div id="fileUpload">
    <form action="index.php?c=order&a=configurator" method="POST" enctype="multipart/form-data">
        Select model to upload (only .stl):
        <input type="file" name="fileToUpload" id="fileToUpload">
        <input type="submit" value="Upload" name="submit">
    </form>
</div>

<div id="modelSettings">
	<form action="index.php?c=order&a=configurator" method="POST">

		<label for="infill" id="banana">Infill:  </label>
		<input type="number"
		       id="infill"
		       name="infill"
		       min="1"
		       max="100"
		       placeholder="80"
		       required value=<?php echo (isset($_POST['infill']) ? $_POST['infill'] : ''); //default Values?>
		>

		<br>

		<label for="resolution">Auflösung:  </label>
		<input list="resolution"
		       name="resolution"
		       placeholder=<?php echo ('0.20'); ?>
		       required value=<?php echo (isset($_POST['resolution']) ? $_POST['resolution'] : ''); ?>
		>
		<datalist id="resolution" >
			<?php

			for ($index = 7; $index >= 1; $index --)
			{
				$resolution = ($index * 4) / 100;

				echo '<option value="' . number_format($resolution, 2, '.', '') . '">';


			}

			?>
		</datalist>

		<br>

		<label for="filaments">Filament:  </label>
		<input list="filament"
		       name="filament"
		       placeholder=<?php echo ($filaments[0]['type'] . ':' . $filaments[0]['color']); ?>
		       required value=<?php echo (isset($_POST['filament']) ? $_POST['filament'] : ''); ?>
		>
		<!-- name ist der key, aus dem php den Wert erhält -->
			<datalist id="filament" > <!-- id muss selben key wie list oben drüber haben -->
				<?php
					foreach ($filaments as $filament)
					{
						echo '<option value="' . $filament['type'] . ': ' . $filament['color'] . '">';
					}
				?>
			</datalist>
		<br>
		<input type="submit">
	</form>
</div>