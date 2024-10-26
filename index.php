<?php

// proto code taken from a module in my own framework
// php, mysql, bootstrap5, jquery

// get authed and wrap a load of stuff - or not
//require_once("../inc/d23.php");

// be part of a bigger app - or not
//require_once("../inc/vars.php");

// here though, we need this
require_once("mpfuncs.php");

// define output
    // root loc
    // grid size
    // grid shape
// choose poi type
// choose options
// process

$loca = 0; 			// cant remember
$writefile = 0; 	// actually write the file to the filesystem
$shoimg = 'd-none';	// don't look at this
$items = 0;			// cant remember
$smallgrid = 2;		// something that I think went obselete

$_SESSION['mpbuild'] = isset($_SESSION['mpbuild']) ? $_SESSION['mpbuild'] : array();
$_SESSION['mpbuild']['items'] = isset($_SESSION['mpbuild']['items']) ? $_SESSION['mpbuild']['items'] : array();
$_SESSION['mpbuild']['loca'] = isset($_SESSION['mpbuild']['loca']) ? $_SESSION['mpbuild']['loca'] : '';
$_SESSION['mpbuild']['writefile'] = isset($_SESSION['mpbuild']['writefile']) ? $_SESSION['mpbuild']['writefile'] : 0;

$rootX = isset($_SESSION['mpbuild']['rootX']) ? $_SESSION['mpbuild']['rootX'] : 200000.000000;
$rootY = isset($_SESSION['mpbuild']['currY']) ? $_SESSION['mpbuild']['currY'] : 0.000000;

$stepX = 60;
$stepY = 60;
$gridsize = 6;

$numitems = 12;
$numbushes = 11;
$numclutter = 6;
$numbenches = 3;
$numtables = 3;
$numsheds = 3;
$numbins = 3;
$numchairs = 6;
$ranbushsc = 1;
$ranbushro = 1;

$_SESSION['mpbuild']['gridsize'] = floatval($gridsize);
$_SESSION['mpbuild']['stepX'] = floatval($stepX);
$_SESSION['mpbuild']['stepY'] = floatval($stepY);

$_SESSION['mpbuild']['rootX'] = floatval($rootX);
$_SESSION['mpbuild']['rootY'] = floatval($rootY);

$_SESSION['mpbuild']['currX'] = isset($_SESSION['mpbuild']['currX']) ? $_SESSION['mpbuild']['currX'] : $_SESSION['mpbuild']['rootX'];
$_SESSION['mpbuild']['currY'] = isset($_SESSION['mpbuild']['currY']) ? $_SESSION['mpbuild']['currY'] : $_SESSION['mpbuild']['rootY'];
$_SESSION['mpbuild']['currA'] = 0;


$splash = ($_SESSION['mpbuild']['loca'] == 'POI type') ? '<img class="m-5 img-fluid" src="/imgs/mpbuild.png" />' : '';
$splash = ($numitems == 0) ? '' : '';	


switch($_SESSION['mpbuild']['loca'])
			{
			case "Village":
			$loca = '%residential|houses%';
			break;
			case "Town":
			$loca = '%houseblocks%';
			break;
			case "Stores":
			$loca = '%stores%';
			break;
			case "Ruins":
			$loca = '%ruin_house%';
			break;
			case "Military":
			$loca = '%military|houses%';
			break;
			}

$db = DB::getInstance();
$tjout = get_random_selections("houses",$db,$numitems,$loca,$numbushes,$numclutter,$numbenches,$numtables,$numsheds,$numbins,$numchairs,$ranbushro,$ranbushsc);
//print_r($tjout);
//print_r($MPBtests);
?> 
<form action="/mpbuild" method="post" class="">
	<div class="container-fluid vh-100">
		<div class="mb-auto ">

			<div class="row py-2"> <?php echo $_SESSION['mpbuild']['rootX'];?>
				
				<?php //print_r($_SESSION['mpbuild']);?>

			</div>

			<div class="row">

						<div class="col-1">	
							<label class="sr-only" for="myInputD6"><?php echo $_SESSION['mpbuild']['loca'];?></label>	
							<?php $poityp = ($_SESSION['mpbuild']['loca'] == '') ? "" : "d-none";?>
							<div class="<?php echo $poityp;?>">	
								<button class="btn btn-sm btn-secondary dropdown-toggle" id="myInputD6" type="button" data-bs-toggle="dropdown" aria-expanded="false">Choose </button>	
								<ul class="dropdown-menu">
									<li> <a href="/mpbuild/process?s=Village" class="dropdown-item btn btn-primary btn-lg px-4 me-sm-3">Village</a></li>
									<li> <a href="/mpbuild/process?s=Town" class="dropdown-item btn btn-primary btn-lg px-4 me-sm-3">Town</a></li>
									<li> <a href="/mpbuild/process?s=Stores" class="dropdown-item btn btn-primary btn-lg px-4 me-sm-3">Stores</a></li>
									<li> <a href="/mpbuild/process?s=Ruins" class="dropdown-item btn btn-primary btn-lg px-4 me-sm-3">Ruins</a></li>
									<li> <a href="/mpbuild/process?s=Military" class="dropdown-item btn btn-primary btn-lg px-4 me-sm-3">Military</a></li>
								</ul>
							</div>
						</div>

						<div class="d-none col-2">	<a href="/mpbuild/refresh" class="btn btn-outline-secondary bg-dark text-light form-control" >Refresh</a>	</div>
						<div class="col">	<a href="/mpbuild/search" class="btn btn-outline-secondary bg-dark text-light form-control" >Search</a>	</div>
						<div class="col">	<a href="/mpbuild/process?r" class="btn btn-outline-secondary bg-dark text-light form-control" >Reset</a>	</div>
						<div class="d-none col-2">	<a href="/mpbuild/process?w" class="btn btn-outline-secondary bg-dark text-light form-control" >Write <?php echo $_SESSION['mpbuild']['writefile'];?> </a>	</div>
						<div class="col">	<a href="/mpbuild/process?d" class="btn btn-outline-danger bg-dark text-light form-control" >DL</a></div>
						<div class="col">	<input class="btn btn-outline-success  bg-dark text-light form-control" name="submit" type="submit" value="Process" />	</div>

						<input type="hidden" name="g" value="1" />

			</div>


			<div class="row">

					<!-- 
					<div class="col-1">		
						<label class="sr-only" for="myInput1">StartX</label>	
						<input class="bg-dark text-light form-control" name="rootx" id="myInput1" type="text"  value="<?php echo $rootX;?>"></div>
					<div class="col-1">		
						<label class="sr-only" for="myInput2">StartY</label>		
						<input class="bg-dark text-light form-control" name="rooty" id="myInput2" type="text"  value="<?php echo $rootY;?>"></div>
					<div class="col-1">		
						<label class="sr-only" for="myInput3">StepX</label>		
						<input class="bg-dark text-light form-control" name="stepx" id="myInput3" type="number" min="40" max="200" value="<?php echo $stepX;?>"></div>
					<div class="col-1">		
						<label class="sr-only" for="myInput4">StepX</label>		
						<input class="bg-dark text-light form-control" name="stepy" id="myInput4" type="number" min="40" max="200" value="<?php echo $stepY;?>"></div>
					<div class="col-1">		
						<label class="sr-only" for="myInput5">Gridsize</label>		
						<input class="bg-dark text-light form-control" name="gridsize" id="myInput5" type="number" min="6" max="12" value="<?php echo $gridsize;?>"></div>
					-->
			</div>	

			<?php echo $splash;?>


			<div class="row row-flex m-2" id="">


				<?php 	
					foreach ($tjout as $itemname) 
					{
					$isrc = 'Land_'.$itemname.'.webp';

					echo '<div class="col-3"><div class="bg-dark text-light small m-1 p-2 card">'.$itemname.'<br /><img class="'.$shoimg.' img-fluid"  src="/imgs/objimg/'.$isrc.'" /></div></div>'; //
					}?>
			</div>


			<div class="card p-2 mt-3 bg-dark text-light">
						<div style="max-height: 24vh; overflow-y: auto;">
							<pre><?php $o=show_selections($_SESSION['mpbuild']['items']); echo $o; ?></pre>
						</div>
				</div>


					<div class=" card p-2 mt-3 bg-dark text-light">
						<div style="max-height: 20vh; overflow-y: auto;">
						
							<pre><?php //include("../public/file.txt"); ?></pre>
						</div>
						</div>

		</div>	
	</div>
</form>



<script>
$(document).ready(function(){

});
</script>

<script>
$(document).ready(function(){
	
});
</script>
