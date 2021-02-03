<?php


$script = 'Prusa_Slicer'.DIRECTORY_SEPARATOR.'test.sh';

$s = '/Applications/XAMPP/xamppfiles/htdocs/Drueckler3DDrucke/Prusa_Slicer/buildScript.sh';

$output = [];


echo exec('pwd') . '<br>';

//exec($s, $output, $retvar);

//$o = shell_exec($s);

$last_line = system($s, $retval);

echo json_encode($last_line) . '<br>';
echo json_encode($retval) . '<br>';

//foreach ($output as $item) {
//	echo json_encode($item) . '<br>';
//}