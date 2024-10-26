<?php 

// proto code taken from a module in my own framework
// php, mysql, bootstrap5, jquery

// get authed and wrap a load of stuff - or not
//require_once("../inc/d23.php");

// be part of a bigger app - or not
//require_once("../inc/vars.php");

// here though, we need this
require_once("mpfuncs.php");
  
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dztpls = array();
$count = 0;
if($xml = simplexml_load_file('/var/www/vhosts/admin-bordon/components/mpbuild/DZ.tml')) { echo "ok";};
//var_dump($xml);exit;
foreach ($xml->Template as $rl) 
	{
	if( (substr(strtolower($rl->File),0,8) == 'dz\plant') || (substr(strtolower($rl->File),0,8) == 'dz\rocks') || (substr(strtolower($rl->File),0,8) == 'dz\struc') || (substr(strtolower($rl->File),0,8) == 'dz\water')) 
	//if( substr(strtolower($rl->File),0,2) == 'dz')
		{
		$nothx = str_contains(strtolower($rl->File),'proxy');
		$nothx = str_contains(strtolower($rl->File),'proxies');
		if(!$nothx)
			{
			$dztpls[$count]['name'] = $rl->Name; // . PHP_EOL;
			$dztpls[$count]['path'] = $rl->File; // . PHP_EOL;
			// also split the p3d from the end
			$mkpath = $dztpls[$count]['path'];
			$mkpath = explode('\\',$mkpath);
			$dztpls[$count]['path0'] = $mkpath[0];
			$dztpls[$count]['path1'] = $mkpath[1];
			$dztpls[$count]['path2'] = $mkpath[2];
			$count++;
			}
		}
	}

	//print_r($dztpls);exit;
$db = DB::getInstance();

foreach ($dztpls as $itemname) 
	{

	$itemDir0 = trim($itemname['path1']);
	$itemDir1 = trim($itemname['path2']);
	$itemnameD = trim($itemname['name']);
	$itempathD = str_replace("\\","|",trim($itemname['path']));

	$fields=array(
					 'base_name'=>$itemnameD,
					 'full_name'=>$itempathD,
					 'directory_name'=>$itemDir0,
					 'directory'=>$itemDir1					
					); //column_name=>entry
	$db->insert('models',$fields);
	}
?> 

<div class="row vh-100">
	<div class="col-xl-6 mx-auto">
		<div class="mb-4" style="max-height: 48vh; overflow-y: auto;">
				<ul class="list-group" id="myList">
					<?php						 		
					foreach ($dztpls as $itemname) 
						{
						echo strtolower('<li>
						'.$itemname['path0'].' 
						'.$itemname['path1'].'
						'.$itemname['path2'].'
						'.$itemname['name'].'
						'.$itemname['path'].'
						</li>'); 
						} 
						?>
				</ul>	
		</div>
		<a href="/mpbuild" class="btn btn-outline-secondary form-control" >Back</a>
	</div>
</div>