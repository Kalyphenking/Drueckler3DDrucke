<?php
//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

//$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];
$filaments = $_SESSION['filaments'];
//$filamentTypes = $_SESSION['filamentTypes'];

$printTime = isset($_SESSION['printTime']) ? $_SESSION['printTime'] : 0;
$printPrices = isset($_SESSION['printPrices']) ? $_SESSION['printPrices'] : [];

echo "PrintTime: $printTime <br><br>";
echo "PrintPrices: $printPrices <br><br>";

//$glbFileName = isset($GLOBALS['glbFileName']) ? $GLOBALS['glbFileName'] : '/uploads/default/glb/6021449f3c57b_3DModelHochladen.glb';
$modelName = isset($_SESSION['modelName']) ? $_SESSION['modelName'] : '';

//echo isset($_SESSION['glbFileName']) ? $_SESSION['glbFileName'] : '';

//echo 'http://localhost/Drueckler3DDrucke'.DIRECTORY_SEPARATOR.UPLOADSPATH. 'glb'.DIRECTORY_SEPARATOR.$gltfFileName;

?>

<div class="modelViewerDiv">
    <model-viewer id="modelViewer" loading="lazy" src="uploads/default/glb/6021449f3c57b_3DModelHochladen.glb"  alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>
    <!--        <model-viewer src="http://localhost/Drueckler3DDrucke/uploads/temp/glb/6021449f3c57b_TopfdeckelTeil.glb" style="height: 500px; width: 50%" alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>-->

    <label class="phpBased">Für Modelvorschau JavaScript aktivieren</label>
    <br>
    <br>
    <br>
    <label><?=$modelName?></label>
</div>

<div class="orderContent">

    <div id="fileUpload">
        <form action="index.php?c=order&a=configurator" method="POST" enctype="multipart/form-data">

            <button class="javaScriptBased" id="uploadFileButton">Model auswählen</button>
            <input class="phpBased" type="file" name="uploadFile" id="uploadFile" onchange="uploadModel()" value="Model auswählen" required>

            <br>

            <input class="phpBased" id="submitUpload" type="submit" value="Model hochladen">

        </form>
    </div>


    <div id="modelSettings">
        <form action="index.php?c=order&a=configurator" method="POST">

            <label for="infill"  id="banana">Infill:  </label>
            <input type="number"
                   name="infill"
                   id="infill"
                   name="infill"
                   min="1"
                   max="100"
                   placeholder="80"
                   required value=<?php echo (isset($_POST['infill']) ? $_POST['infill'] : ''); //default Values?>
            >

            <br>

            <label for="resolution">Auflösung:  </label>
<!--            <input list="resolution"-->
<!--                   name="resolution"-->
<!--                   placeholder=--><?php //echo ('0.20'); ?>
<!--                   required value=--><?php //echo (isset($_POST['resolution']) ? $_POST['resolution'] : ''); ?>
<!--            >-->
            <select id="resolution" name="resolution">
				<?php

				for ($index = 7; $index >= 1; $index --)
				{
					$resolution = ($index * 4) / 100;

//					echo '<option value="' . number_format($resolution, 2, '.', '') . '">';
					echo '<option>' . number_format($resolution, 2, '.', '') . '</option>';


				}

				?>
            </select>

            <br>

            <label for="filaments">Filament:  </label>
<!--            <input list="filament"-->
<!--                   name="filament"-->
<!--                   placeholder=--><?php //echo ($filaments[0]['type'] . ':' . $filaments[0]['color']); ?>
<!--                   required value=--><?php //echo (isset($_POST['filament']) ? $_POST['filament'] : ''); ?>
<!--            >-->
            <!-- name ist der key, aus dem php den Wert erhält -->
            <select id="filament" name="filament" onchange="changeColor()"> <!-- id muss selben key wie list oben drüber haben -->
				<?php
				foreach ($filaments as $filament)
				{
//					echo '<option value="' . $filament['type'] . ': ' . $filament['color'] . '">';
					echo '<option value="'. $filament['rgba'] .'">' . $filament['type'] . ': ' . $filament['color'] . '</option>';
				}
				?>
            </select>
            <br>
            <input type="submit" name="submit" value="Model berechnen">

            <?php


            ?>


        </form>
    </div>
</div>
