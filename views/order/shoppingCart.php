<?php

$shoppingCart = $_SESSION['shoppingCart'];

echo json_encode($shoppingCart)

?>



<div class="modelViewerDiv">

    <label class="phpBased">Für Modelvorschau JavaScript aktivieren</label>
</div>

<div class="orderContent">
    <h1>Warenkorb</h1>

    <table>

	    <?php
	        if (!empty($shoppingCart)) {

            }
	    ?>

    </table>



</div>

<?php






