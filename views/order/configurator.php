<?php
//if (isset($_SESSION['filaments'])) {
//	$filaments = $_SESSION['filaments'];
//}

//$filaments = isset($_SESSION['filaments']) ? $_SESSION['filaments'] : [];
$filaments = $_SESSION['filaments'];
//$filamentTypes = $_SESSION['filamentTypes'];

$printTime = isset($_SESSION['printTime']) ? $_SESSION['printTime'] : '';
$printPrices = isset($_SESSION['printPrices']) ? $_SESSION['printPrices'] : [''];
$modelName = isset($_SESSION['modelName']) ? $_SESSION['modelName'] : '';

$infill = isset($_SESSION['infill']) ? $_SESSION['infill'] : '30';
$selectedResolution = isset($_SESSION['resolution']) ? $_SESSION['resolution'] : null;
$filamentColor = isset($_SESSION['filamentColor']) ? $_SESSION['filamentColor'] : null;
$filamentColorCode = isset($_SESSION['filamentColorCode']) ? $_SESSION['filamentColorCode'] : null;


echo "filamentColorCode: $filamentColorCode <br><br>";
echo "selectedResolution: $selectedResolution <br><br>";
echo "filamentColor: $filamentColor <br><br>";
echo "PrintTime: $printTime <br><br>";
echo "PrintPrices: $printPrices[0] <br><br>";


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

            <input class="phpBased" id="submitUpload" name="submitUpload" type="submit" value="Model hochladen">

        </form>
    </div>


    <div id="modelSettings">
        <form action="index.php?c=order&a=configurator" method="POST">

            <label for="infill"  id="banana">Infill:  </label>
            <input type="number"
                   name="infill"
                   id="infill"
                   name="infill"
                   min="30"
                   max="100"
                   placeholder="80"
                   required value=<?=$infill?>
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
                if ($selectedResolution) {
	                echo '<option value="'.$selectedResolution.'" selected hidden>'.number_format($selectedResolution, 2, '.', '').'</option>';
                }
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
                if ($filamentColor && $filamentColorCode) {
	                echo '<option value="'.$filamentColorCode.'"selected hidden>'.$filamentColor.'</option>';
                }
				foreach ($filaments as $filament)
				{
//					echo '<option value="' . $filament['type'] . ': ' . $filament['color'] . '">';
					echo '<option value="'. $filament['rgba'] .'">' . $filament['type'] . ': ' . $filament['color'] . '</option>';
				}
				?>
            </select>
            <br>
            <input type="submit" name="submitCalculation" value="Model berechnen">
            <input type="submit" name="submitContinue" value="Weiter">

            <?php


            ?>


        </form>
    </div>
</div>
