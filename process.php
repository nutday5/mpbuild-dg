<?php session_start();

if(isset($_GET['d'])) //download
	{
		$file = 'file.txt';
		$fp = fopen($file, 'w');
		$delimiter = ','; // keep the delimiter as a comma
		$enclosure = "'"; // set the enclosure to a single quote
		foreach ($_SESSION['mpbuild']['items'] as $fields) 
			{
			fputcsv($fp, $fields, $delimiter, $enclosure);
			}
		fclose($fp);
		$_SESSION['mpbuild'] = array();

		if (file_exists($file)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename="'.basename($file).'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($file));
			readfile($file);
			exit;
		}
	}

if(isset($_GET['w'])) //writefile
	{
	
	$_SESSION['mpbuild']['writefile'] = 1;
	header("Location: /mpbuild");
	exit;
	}

if(isset($_GET['r'])) //reset
	{
	unset($_SESSION['mpbuild']);
	$_SESSION['mpbuild'] = array();
	header("Location: /mpbuild");
	exit;
	}

if(isset($_GET['s'])) //set location
	{
	$loca = $_GET['s'];
	$_SESSION['mpbuild']['loca'] = $loca;
	header("Location: /mpbuild");
	exit;
	}




    ?>