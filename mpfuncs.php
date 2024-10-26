<?php

function nu_get_selections($a=1,$b=2)
    {

    }


function show_selections($thisarr)
	{
	$retval = ''; //print_r($_SESSION['mpbuild'], false);
	foreach ($thisarr as $fields => $val) 
		{
		$d = $val['Name'];
		$retval .= $d.':'.$val['X'].'<br />'; //print_r($d,true);
		} //echo $retval;
	return $retval;
	}

function check_model($modelname)
	{
	
		$retstat = false;

		if 
		( (!str_contains(strtolower($modelname),"proxy")) && (!str_contains(strtolower($modelname),"postel_panelak1_1")) )
		{
		$retstat = true;
		}

		return $retstat;	
	}

function get_walls($selec,$db,$ni=1)
	{

		$jout = array();
		$jout2 = array();
		switch($selec)
			{
				case "residential":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%pole.%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				
				default:
				$MPBtests = '';
				return $jout;
				break;

			}

		if ($MPBtests->count() > 0)
			{
				$jin = $MPBtests->results();
				foreach ($jin as $row) 
					{
					$m = $row->base_name;
					if(check_model($m))
						{
						$jout[] = ($selec == "all") ? $row->full_name : $m;
						}
					}
					$thisfence = substr($m,0,-5); //echo $thisfence;
					$MPBtests2 = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%".$thisfence."%' ORDER BY RAND() LIMIT 10 "); 
					$jin2 = $MPBtests2->results();
					foreach ($jin2 as $row2) 
						{
						$m2 = $row2->base_name;
						if(check_model($m2))
							{
							$jout[] = $m2;
							}
						}
					

			}
	
		return $jout;
	}

function populate_session($tcou,$mm,$bRO=0,$bSC=0)
	{

		// rand scale for plants
		$scales = rand(85,125) / 100;
		// rand rot for plants
		$rotations = rand(0,359);

		$isbush = (substr($mm,0,2) == 'b_') ? 1 : 0;

		$_SESSION['mpbuild']['items'][$tcou]['Name'] = '"'.$mm.'"';
		$_SESSION['mpbuild']['items'][$tcou]['X'] = $_SESSION['mpbuild']['currX'];
		$_SESSION['mpbuild']['items'][$tcou]['Y'] = $_SESSION['mpbuild']['currY'];

		if(($bRO == 1) && ($isbush == 1))
			{
			$_SESSION['mpbuild']['items'][$tcou]['A'] = $rotations;
			}
		else
			{
			$_SESSION['mpbuild']['items'][$tcou]['A'] = $_SESSION['mpbuild']['currA'];
			}
		
		$_SESSION['mpbuild']['items'][$tcou]['Pitch'] = 0.000000;
		$_SESSION['mpbuild']['items'][$tcou]['Roll'] = 0.000000;
		
		if(($bSC == 1) && ($isbush == 1))
			{
			$_SESSION['mpbuild']['items'][$tcou]['Scale'] = $scales;
			}
		else
			{
			$_SESSION['mpbuild']['items'][$tcou]['Scale'] = 1.000000;
			}
		
		$_SESSION['mpbuild']['items'][$tcou]['Elevation_r'] = 0.000000;
	}

function get_menu_selections($selec,$db,$ni=20)
	{
		$jout = array();
		switch($selec)
			{

				case "top":
					$MPBtests = $db->query("SELECT DISTINCT directory FROM models
					
					"); 
					break;
					default:
					$MPBtests = '';
					return $jout;
					break;
	
				}
	
			if ($MPBtests->count() > 0)
				{
				$jin = $MPBtests->results();
				foreach ($jin as $row) 
					{
					$m = $row->directory;
					$jout[] = $m;
						
					}
				}
			return $jout;
		
	}
function get_selections($selec,$db,$ni=20)
	{

		$jout = array();
		switch($selec)
			{

				case "top":
					$MPBtests = $db->query("SELECT distinct directory FROM models 
					WHERE disabled = 0 "); 
					break;

				case "bushes":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%|bush%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;

				case "clutter":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%|clutter%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				case "bench":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%|misc_bench%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				case "tables":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%|tables%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				case "bins":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%garbage_bin%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				case "chairs":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND LOWER(full_name) LIKE '%_chair%' ORDER BY RAND() LIMIT ".$ni." "); 
					break;
				case "sheds":
					$MPBtests = $db->query("SELECT base_name,full_name FROM models 
					WHERE disabled = 0 AND 
					((LOWER(full_name) LIKE '%shed_m%') OR (LOWER(full_name) LIKE '%shed_w%')) ORDER BY RAND() LIMIT ".$ni." "); 
					break;


				case "all":
				$MPBtests = $db->query("SELECT * FROM models 
				WHERE disabled = 0 AND LOWER(full_name) NOT LIKE '%proxy%' "); 
				break;
				default:
				$MPBtests = '';
				return $jout;
				break;

			}

		if ($MPBtests->count() > 0)
			{
            $jin = $MPBtests->results();
            foreach ($jin as $row) 
                {
                $m = $row->base_name;
                if(check_model($m))
                    {
                    $jout[] = ($selec == "mall") ? $row->full_name : $m;
                    }
                }
			}
		return $jout;
	}

function get_random_selections($selec,$db,$ni,$loca,$numbushes,$numclutter,$numbenches,$numtables,$numsheds,$numbins,$numchairs,$bRO,$bSC)
	{
	
		$ni=intval($ni);
		switch($selec)
			{
			case "houses":
				//unset($_SESSION['mpbuild']);
				$items = 0;
				$gridcount = 0;
				$smlgridsize = 3;
				$smlgridcount = 0;
				$jout = array();
				$tcou = 0;
				for ($x = 1; $x <= $ni; $x++)
					{

						$MPBtests = $db->query("SELECT base_name,full_name FROM models WHERE disabled = 0 AND LOWER(full_name) LIKE '".$loca."'  ORDER BY RAND() LIMIT 1 "); 
						$jin = $MPBtests->results();
						foreach ($jin as $row) 
							{
								$m = $row->base_name;
							if(check_model($m))
								{
									$jout[] = $m;
									populate_session($tcou,$m);
									$thissqX = $_SESSION['mpbuild']['currX'];
									$thissqY = $_SESSION['mpbuild']['currY'];
									$bushes = get_selections("bushes",$db,$numbushes);
									$bushes = array_merge($bushes,get_selections("clutter",$db,$numclutter));
									$bushes = array_merge($bushes,get_selections("bench",$db,$numbenches));
									$bushes = array_merge($bushes,get_selections("tables",$db,$numtables));
									$bushes = array_merge($bushes,get_selections("sheds",$db,$numsheds));
									$bushes = array_merge($bushes,get_selections("bins",$db,$numbins));
									$bushes = array_merge($bushes,get_selections("chairs",$db,$numchairs));
									$bushes = array_merge($bushes,get_walls("residential",$db,1)); //

									$_SESSION['mpbuild']['currX'] += 16;
									$_SESSION['mpbuild']['currY'] -= 12;


									foreach ($bushes as $bush) 
										{
											$tcou++;
											$_SESSION['mpbuild']['currX'] += $smlgridsize;
											//$_SESSION['mpbuild']['currY'] $smlgridsize;
											populate_session($tcou,$bush,$bRO,$bSC);
											$smlgridcount++;

											if($smlgridcount == $_SESSION['mpbuild']['gridsize'])
											{
												$_SESSION['mpbuild']['currX'] = $thissqX;
												$smlgridcount = 0;	
												$_SESSION['mpbuild']['currY'] += $smlgridsize;
											}

											//$_SESSION['mpbuild']['currY'] += $smlgridsize;
											
										
										}
										
									$_SESSION['mpbuild']['currX'] = $thissqX + $_SESSION['mpbuild']['stepX'];
									$_SESSION['mpbuild']['currY'] = $thissqY;
									
									$gridcount++;
									
									if($gridcount == $_SESSION['mpbuild']['gridsize'])
										{
											$_SESSION['mpbuild']['currX'] = $_SESSION['mpbuild']['rootX'];
											$gridcount = 0;	
											$_SESSION['mpbuild']['currY'] = $_SESSION['mpbuild']['currY'] + $_SESSION['mpbuild']['stepY'];
										}
									$tcou++;
									$items++;
								
								}
								
							}		

					}
			return $jout;
			break;

			default:
			$MPBtests = '';
			return $jout;
			break;

		}

	}
	
?>