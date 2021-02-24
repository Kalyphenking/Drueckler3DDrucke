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

$amount = isset($_POST['amount']) ? $_POST['amount'] : 1;

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
}

//echo "filamentColorCode: $filamentColorCode <br><br>";
//echo "selectedResolution: $selectedResolution <br><br>";
//echo "Filament: $filamentColor <br><br>";
//echo "PrintTime: $printTime <br><br>";
//echo "PrintPrices: $printPrices[0] <br><br>";


?>

<div class="configurator-container">
    <div class="modelViewer">
        <model-viewer id="modelViewer" class="javaScriptBased" loading="lazy" src="uploads/default/glb/3DModelHochladen.glb"  alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>
        <!--        <model-viewer src="http://localhost/Drueckler3DDrucke/uploads/temp/glb/6021449f3c57b_TopfdeckelTeil.glb" style="height: 500px; width: 50%" alt="A 3D model of an astronaut" auto-rotate camera-controls></model-viewer>-->
        <!---->
        <label id="missingJavaScriptMessage" class="phpBased text-warning">Für Modelvorschau JavaScript aktivieren</label>
    </div>
    <div class="test">

    </div>

    <div class="modelSettings">

        <div id="fileUpload">
            <form action="index.php?c=order&a=configurator" method="POST" enctype="multipart/form-data">

                <input type="button" class="javaScriptBased" id="uploadFileButton" value="Model auswählen"></input>
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
                       min="30"
                       max="100"
                       placeholder="30"
                       required value=<?= (isset($_POST['infill']) ? $_POST['infill'] : ''); //default Values?>
                >

                <br>

                <label for="resolution">Auflösung:  </label>
                <!--            <input list="resolution"-->
                <!--                   name="resolution"-->
                <!--                   placeholder=--><?php //echo ('0.20'); ?>
                <!--                   required value=--><?php //echo (isset($_POST['resolution']) ? $_POST['resolution'] : ''); ?>
                <!--            >-->
                <select id="resolution" name="resolution">
                    <!--                <option value="--><?//= (isset($_POST['resolution']) ? $_POST['resolution'] : 0.28); //default Values?><!--" selected hidden>--><?//=number_format(isset($_POST['resolution']) ? $_POST['resolution'] : 0.28, 2, '.', '')?><!--</option>-->
					<?php
					//                if ($selectedResolution) {
					//	                echo '<option value="'.$selectedResolution.'" selected hidden>'.number_format($selectedResolution, 2, '.', '').'</option>';
					//                }
					for ($index = 7; $index >= 1; $index --)
					{
						$resolution = ($index * 4) / 100;

						$previousResolution = isset($_POST['resolution']) ? $_POST['resolution'] : 0.28;

						if ($resolution == $previousResolution) {
							echo '<option selected>' . number_format($resolution, 2, '.', '') . '</option>';
						} else {
							echo '<option>' . number_format($resolution, 2, '.', '') . '</option>';
						}

					}

					?>
                </select>

                <br>

                <label for="filaments">Filament:  </label>
                <select id="filament" name="filament" onchange="changeColor()"> <!-- id muss selben key wie list oben drüber haben -->
					<?php
                    echo json_decode($filamentColor).'<br>'.json_decode($filamentColorCode);
					if ($filamentColor && $filamentColorCode) {
						echo '<option value="'.$filamentColorCode.'"selected hidden>'.$filamentColor.'</option>';
					}
					foreach ($filaments as $filament)
					{
						echo '<option value="'. $filament['rgba'] .'">' . $filament['type'] . ': ' . $filament['color'] . '</option>';
					}
					?>
                </select>
                <br>
                <label for="filaments">Menge:  </label>
                <input type="number"
                       name="amount"
                       id="amount"
                       min="1"
                       max="1000"
                       placeholder="1"
                       required value=<?=$amount?>
                >
                <br>


                <input type="submit" name="submitCalculation" value="Model berechnen">
                <input type="submit" name="submitContinue" value="In den Warenkorb">
                <label class="errorMessage"><?=$error?></label>

				<?php


				?>


            </form>
        </div>
    </div>
</div>


