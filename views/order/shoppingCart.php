<?php

$shoppingCart = isset($_SESSION['shoppingCart']) ? $_SESSION['shoppingCart'] : [];

$error = '';

if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
	$error = $_SESSION['error'];
}
?>

<!--<div class="modelViewerDiv">-->
<!---->
<!--    <label class="phpBased">Für Modelvorschau JavaScript aktivieren</label>-->
<!--</div>-->
<!--<form action="index.php?c=order&a=shoppingCart" method="POST" enctype="multipart/form-data">-->
    <div class="orderContent">
            <?php
                if (!empty($shoppingCart)) {

                    echo '
                        <h1>Warenkorb</h1>
                        <form action="index.php?c=order&a=shoppingCart" method="POST" enctype="multipart/form-data">
                        <table>
                    ';

                    foreach ($shoppingCart as $key => $item) {
                        $fileName = $item[6];

                        echo'<tr>';
                            echo '<td>
                                <model-viewer 
                                id="modelViewer-'.$key.'" 
                                loading="lazy" 
                                src="'.$fileName.'"  
                                alt="A 3D model of an astronaut" 
                                auto-rotate>
                                </model-viewer>
                            </td>';

                            echo '<td>'.$item[0].'</td>';
                            echo '<td>'.$item[1].'</td>';
                            echo '<td>'.$item[2].'</td>';
                            echo '<td>'.$item[3].'</td>';
                            echo '<td>'.$item[4].'</td>';
                            echo '<td>'.$item[5][0].'</td>';
                            echo '<td>'.$item[6].'</td>';

                            echo '<td>
                                
                                     <input 
                                        type="checkbox" 
                                        id="scales" 
                                        name="'.$key.'"
                                     >  
                                
                                
                            </td>';


                        echo'</tr>';

                        echo '<script>displayModel("'.$fileName.'", "modelViewer-'.$key.'")</script>';

                        echo '
                            </table>
                            
                            
                        ';

                    }
                } else {
	                echo '
                        <h1>Warenkorb leer</h1>
                        ';
                }
            ?>
            <br>
            <input type="submit" name="submitDelete" value="Auswahl löschen">
            <input type="submit" name="submit" value="Weiter">
            <br>
            <label class="errorMessage"><?=$error?></label>


        </form>

    </div>

    <div class="shoppingCartFooter">

    </div>
<!--</form>-->

<?php






