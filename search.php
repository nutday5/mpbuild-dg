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

$db = DB::getInstance();
$tjout3 = get_selections("all",$db);

$mpmenu = get_menu_selections("top",$db);
foreach ($mpmenu as $itemmpmenu) 
	{
	// make a menu
	//echo '<div>'.$itemmpmenu.'</div>';
	}
?> 

<div class="row vh-100">
	<div class="col-xl-6 mx-auto">
			<div class="card mb-4 "><input class="form-control" id="myInput" type="text" placeholder="Search.."></div>
			<div class="mb-4" style="max-height: 48vh; overflow-y: auto;">
				<ul class="list-group" id="myList">
					<?php 		
					foreach ($tjout3 as $itemname) 
						{
						echo '<li>'.$itemname.'</li>';
						}
						?>
				</ul>
			</div>
			<a href="/mpbuild" class="btn btn-outline-secondary form-control" >Back</a>
	</div>
</div>



<script>
	$(document).ready(function(){
	$("#myInput").on("keyup", function() {
		var value = $(this).val().toLowerCase();
		$("#myList li").filter(function() {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});
	});
</script>

<script>
$(document).ready(function(){

	
});
</script>