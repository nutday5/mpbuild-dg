<?php 

// proto code taken from a module in my own framework
// php, mysql, bootstrap5, jquery

// get authed and wrap a load of stuff - or not
//require_once("../inc/d23.php");

// be part of a bigger app - or not
//require_once("../inc/vars.php");

// here though, we need this
require_once("mpfuncs.php");

$items = 0;


//print_r($MPBtests);
$db = DB::getInstance();
$OOEout = get_selections("all",$db);
//$mpmenu = get_menu_selections("top",$db);
//foreach ($mpmenu as $itemmpmenu) 
//{
//echo '<div>'.$itemmpmenu.'</div>';
//}


//Make loop variable to count cells across
$tcou = 0;
$cols = 0;
$grid = 30;
$startX = 200000;
$startY = 0;
$_SESSION['mpbuild']['items'] = array();
$currX = $startX;
$currY = $startY;
foreach ($OOEout as $itemnames) 
    {
    if (($cols % 50) == 0) 
        {
        $currX = 200000;
        $currY = $currY + $grid;        
        }

    $mi = explode("|",$itemnames);
    $itemname = $mi[0];             

         //  echo $currX.' '.$currY.' '.$itemname.'<br/>';
    $isbush = (substr($itemname,0,2) == 'b_') ? 1 : 0;

    $_SESSION['mpbuild']['items'][$tcou]['Name'] = '"'.$itemname.'"';
    $_SESSION['mpbuild']['items'][$tcou]['X'] = $currX;
    $_SESSION['mpbuild']['items'][$tcou]['Y'] = $currY;
    $_SESSION['mpbuild']['items'][$tcou]['A'] = 0;
    $_SESSION['mpbuild']['items'][$tcou]['Pitch'] = 0.000000;
    $_SESSION['mpbuild']['items'][$tcou]['Roll'] = 0.000000;
    $_SESSION['mpbuild']['items'][$tcou]['Scale'] = 1.000000;
    $_SESSION['mpbuild']['items'][$tcou]['Elevation_r'] = 0.000000;

    $currX = $currX + $grid;
    //$currY = $currY + $grid;
    $cols++;
    $tcou++;
    }

    $file = 'oneofeach.txt';
    $fp = fopen($file, 'w');
    $delimiter = ','; // keep the delimiter as a comma
    $enclosure = "'"; // set the enclosure to a single quote
    foreach ($_SESSION['mpbuild']['items'] as $fields) 
        {
        fputcsv($fp, $fields, $delimiter, $enclosure);
        }
    fclose($fp);
    $_SESSION['mpbuild'] = array();

    ?>



<div class="row vh-100">

	<div class="col-xl-6 mx-auto">

			<a href="/mpbuild" class="btn btn-outline-secondary form-control" >Back</a>
	</div>

</div>
