<?php

$orderPrice = $_SESSION['printPrices'][0];
$orderInfill = $_SESSION['infill'];
$orderResolution = $_SESSION['resolution'];
$filamentColor = $_SESSION['filamentColor'];
$orderPrintTime = $_SESSION['printTime'];
$orderModelName = $_SESSION['modelName'];

$shoppingCart = $_SESSION['shoppingCart'];

//echo json_encode($shoppingCart)

?>



<div class="modelViewerDiv">

    <label class="phpBased">Für Modelvorschau JavaScript aktivieren</label>
</div>

<div class="orderContent">
    <h1>Warenkorb</h1>

    <table>

	    <?php
	    foreach ($shoppingCart as $key=>$item) {

		    echo '<tr>';
		    echo '<td>
                    <model-viewer class="modelViewerShopppingCart" 
                    id="modelViewerShopppingCart-'.$key.'" 
                    loading="lazy" 
                    src="uploads/default/glb/6021449f3c57b_3DModelHochladen.glb"  
                    alt="A 3D model of an astronaut" 
                    auto-rotate 
                    camera-controls>

                </model-viewer>
                </td>';
		    echo '<td>'.$item[0].'</td>';
		    echo '<td>'.$item[1].'</td>';
		    echo '<td>'.$item[2].'</td>';
		    echo '<td>'.$item[3].'</td>';
		    echo '<td>'.$item[4].'</td>';
		    echo '<td>'.$item[5].'</td>';
		    echo '<td>'.$item[6].'</td>';

		    echo '</tr>';
		    $file = $item[6];
//		    echo "file: $file <br>";
		    echo '<script>displayModel("'.$file.'", "modelViewerShopppingCart-'.$key.'")</script>';
	    }
	    ?>

    </table>



</div>

<?php






