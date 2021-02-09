<?php
//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

//$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];
$filaments = $_SESSION['filaments'];
//$filamentTypes = $_SESSION['filamentTypes'];

$printTime = isset($_SESSION['printTime']) ? $_SESSION['printTime'] : 0;
$printPrices = isset($_SESSION['printPrices']) ? $_SESSION['printPrices'] : [];

$gltfFileName = isset($_SESSION['gltfFileName']) ? $_SESSION['gltfFileName'] : 'no';

//echo 'http://localhost/Drueckler3DDrucke'.DIRECTORY_SEPARATOR.UPLOADSPATH. 'glb'.DIRECTORY_SEPARATOR.$gltfFileName;

?>

<div class="orderContent">

    <div class="modelViewer">
        <model-viewer id="modelViewer" src="<?='http://localhost/Drueckler3DDrucke'.DIRECTORY_SEPARATOR.UPLOADSPATH.'temp'.DIRECTORY_SEPARATOR.'glb'.DIRECTORY_SEPARATOR.$gltfFileName?>" style="height: 500px; width: 50%" alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>
<!--        <model-viewer src="http://localhost/Drueckler3DDrucke/uploads/temp/glb/6021449f3c57b_TopfdeckelTeil.glb" style="height: 500px; width: 50%" alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>-->

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

            <?php


            ?>


        </form>
    </div>
</div>
