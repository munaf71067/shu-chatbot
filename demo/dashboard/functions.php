<?php

function imgcr($filename,$pt,$savept,$w_img,$h_img,$svname) {

$path=$pt."/";
$thumb1=$savept."/";
$main_image=$filename;




$rt=explode(".",$filename);


$x=explode('.',$main_image);


	$n_w=$w_img;
	$n_h=$h_img;
	if ($x[1]=='jpg' || $x[1]=='jpeg') {
		$im=imagecreatefromjpeg($path.$main_image);
	} else if ($x[1]=='gif') {
		$im=imagecreatefromgif($path.$main_image);
	} else if ($x[1]=='png') {
		$im=imagecreatefrompng($path.$main_image);
	} else {
		echo "Invalid Image File<br>";
	}

	$im_width = imagesx($im);
	$im_height = imagesy($im);
	$resize=false;




if ($im_width > $im_height) {
	$thumb_w=$n_w;
	$thumb_h=$n_h;
	//$im_height*($n_h/$im_width);
}
if ($im_width < $im_height) {
	$thumb_w=$im_width*($n_w/$im_height);
	$thumb_h=$n_h;
}
if ($im_width == $im_height) {
	$thumb_w=$n_w;
	$thumb_h=$n_h;
}

$im_n_height=round($thumb_h);
$im_n_width=round($thumb_w);

	$im_new=imagecreatetruecolor( $im_n_width, $im_n_height);
	if ( $x[1]=='gif' ) {
		$trnprt_indx = imagecolortransparent($im);

		// If we have a specific transparent color
		if ($trnprt_indx >= 0) {

			// Get the original image's transparent color's RGB values
			$trnprt_color    = imagecolorsforindex($im, $trnprt_indx);

			// Allocate the same color in the new image resource
			$trnprt_indx    = imagecolorallocate($im_new, $trnprt_color['red'], $trnprt_color['green'], $trnprt_color['blue']);

			// Completely fill the background of the new image with allocated color.
			imagefill($im_new, 0, 0, $trnprt_indx);

			// Set the background color for new image to transparent
			imagecolortransparent($im_new, $trnprt_indx);


		}  else if ($x[1]=='png') {
			imagealphablending($im, false);

			$color = imagecolorallocatealpha($im, 0, 0, 0, 127);

			imagefill($im_new, 0, 0, $color);
			imagesavealpha($im_new, true);
		}
	}

	imagecopyresampled($im_new,$im,  0, 0, 0, 0,$im_n_width, $im_n_height, $im_width, $im_height);
	//imagecopyresized($im_new,$im,  0, 0, 0, 0,$im_n_width, $im_n_height, $im_width, $im_height);
//echo $paththumb1;
	if ($x[1]=='jpg' || $x[1]=='jpeg') {
		imagejpeg($im_new,$thumb1.$svname,100);
	} else if ($x[1]=='gif') {
		imagegif($im_new,$thumb1.$svname,100);
	} else if ($x[1]=='png') {
		imagepng($im_new,$thumb1.$svname,100);
	} 

}


function showTimeLeft($time)
{
	$now = strtotime("now");
	$timeDiff = $time - $now;

	if($timeDiff > 0)
	{
		$stl_days = floor($timeDiff/60/60/24);
		$stl_hours = $timeDiff/60/60%24;
		$stl_mins = $timeDiff/60%60;
		$stl_secs = $timeDiff%60;

		if($stl_days)
		{
			$text = $stl_days . " Day(s)";
			if($stl_hours)
			{
				$text .= ", " .$stl_hours . " Hour(s) ";
			}
		}
		elseif($stl_hours)
		{
			$text = $stl_hours . " Hour(s)";
			if($stl_mins)
			{
				$text .= ", " .$stl_mins . " Minute(s) ";
			}
		}
		elseif($stl_mins)
		{
			$text = $stl_mins . " Minute(s)";
			if($stl_secs)
			{
				$text .= ", " .$stl_secs . " Second(s) ";
			}
		}
		elseif($stl_secs)
		{
			$text = $stl_secs . " Second(s)";
		}
	}
	else
	{
		$text = "The time is already in the past!";
	}

	return $text;
}
function uploadImage ($file) {
	
	if ((($_FILES[$file]["type"] == "image/gif")
	|| ($_FILES[$file]["type"] == "image/jpeg")
	|| ($_FILES[$file]["type"] == "image/pjpeg"))
	|| ($_FILES[$file]["type"] == "image/png")
	|| ($_FILES[$file]["type"] == "application/octet-stream")
	&& ($_FILES[$file]["size"] < 90000000))
	{
		if ($_FILES[$file]["error"] > 0)
		{
			return 0;
		}
		else
		{
			

			/*if (file_exists("../uploads/" . $_FILES[$file]["name"]))
			{
				return $_FILES[$file]["name"] . " already exists. ";
			}
			else
			{*/
			$name= preg_replace('[\D]', '', microtime());
				if (move_uploaded_file($_FILES[$file]["tmp_name"],
				"../uploads/" . $name. basename($_FILES[$file]["name"]))) {					
					return $name. basename( $_FILES[$file]["name"]);
				} else {
					echo 'upload fail';
				}
			//}
		}
	}
	else
	{
		return  "0";
	}
}


function uploadImageFolder2 ($file,$folder) {

	if ((($_FILES[$file]["type"] == "image/gif")
			|| ($_FILES[$file]["type"] == "image/jpeg")
			|| ($_FILES[$file]["type"] == "image/pjpeg"))
			|| ($_FILES[$file]["type"] == "image/png")
			|| ($_FILES[$file]["type"] == "application/octet-stream")
			&& ($_FILES[$file]["size"] < 90000000))
	{
		if ($_FILES[$file]["error"] > 0)
		{
			return 0;
		}
		else
		{
			$name= preg_replace('[\D]', '', microtime());
			if (move_uploaded_file($_FILES[$file]["tmp_name"],
					"$folder/" . $name.basename($_FILES[$file]["name"]))) {
					return $name.basename($_FILES[$file]["name"]);
			} else {
				echo 'upload fail';
			}
		}
	}
	else
	{
		return  "0";
	}
}

function uploadImageFolder ($file,$folder) {

	if ((($_FILES[$file]["type"] == "image/gif")
			|| ($_FILES[$file]["type"] == "image/jpeg")
			|| ($_FILES[$file]["type"] == "image/pjpeg"))
			|| ($_FILES[$file]["type"] == "image/png")
			|| ($_FILES[$file]["type"] == "application/octet-stream")
			&& ($_FILES[$file]["size"] < 90000000))
	{
		if ($_FILES[$file]["error"] > 0)
		{
			return 0;
		}
		else
		{
			$name= preg_replace('[\D]', '', microtime());
			if (move_uploaded_file($_FILES[$file]["tmp_name"],
					"$folder/" . $name. basename($_FILES[$file]["name"]))) {
					return $name. basename( $_FILES[$file]["name"]);
			} else {
				echo 'upload fail';
			}
		}
	}
	else
	{
		return  "0";
	}
}
function uploadImageArray ($file,$id) {
	echo $_FILES[$file]["type"][$id];
	if ((($_FILES[$file]["type"][$id] == "image/gif")
	|| ($_FILES[$file]["type"][$id] == "image/jpeg")
	|| ($_FILES[$file]["type"][$id] == "image/pjpeg"))
	|| ($_FILES[$file]["type"][$id] == "image/png")
	|| ($_FILES[$file]["type"][$id] == "application/msword")
	|| ($_FILES[$file]["type"][$id] == "application/x-download")
	|| ($_FILES[$file]["type"][$id] == "application/vnd.ms-excel")
	&& ($_FILES[$file]["size"][$id] < 90000000))
	{
		if ($_FILES[$file]["error"][$id] > 0)
		{
			return 0;
		}
		else
		{
			

			/*if (file_exists("../uploads/" . $_FILES[$file]["name"]))
			{
				return $_FILES[$file]["name"] . " already exists. ";
			}
			else
			{*/
			$name= preg_replace('[\D]', '', microtime());
				if (move_uploaded_file($_FILES[$file]["tmp_name"][$id],
				"../uploads/" .$name. basename( $_FILES[$file]["name"][$id]))) {					
					return $name. basename( $_FILES[$file]["name"][$id]);
				}
			//}
		}
	}
	else
	{
		return  "0";
	}
}


function view_puchase ($po_id) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>

|<a href="purchase_order_edit.php?id=<?php echo $po_id; ?>"  data-toggle="tooltip" data-original-title="Edit" title="Edit">
                      <i class="fa fa-edit" aria-hidden="true"></i>
                    </a> | 
                    <a href="purchase_orderProcess.php?del=<?php echo $po_id; ?>" onclick="return confirm('Sure! You want to delete this Purchase Order')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }





	}


function view_party ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>

 | <a href="yarn_from_party_edit.php?id=<?php echo $sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    | 
                    <a href="yarn_from_party_add_db.php?del=<?php echo $sno; ?>" onclick="return confirm('Sure! You want to delete this Yarn Party Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}

	function view_empty_beam ($eb_id) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>

 | <a href="emptybeam_edit.php?id=<?php echo $eb_id ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="emptybeamProcess.php?del=<?php echo $eb_id ?>" onclick="return confirm('Sure! You want to delete this Emptybeam Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}


	function view_half_cone ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>

 | <a href="half_and_fl_cone_edit.php?id=<?php echo $sno ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="half_and_fl_cone_add_db.php?del=<?php echo $sno ?>" onclick="return confirm('Sure! You want to delete this Half and Full Cone Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}


		function view_half_rewide ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
 | <a href="half_cone_rewinding_edit.php?id=<?php echo $sno ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="half_cone_rewinding_add_db.php?del=<?php echo $sno ?>" onclick="return confirm('Sure! You want to delete this Half and Full Cone Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}


		function view_rewind_cone ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
| <a href="rewind_cone_edit.php?id=<?php echo $sno ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="rewind_cone_db.php?del=<?php echo $sno ?>" onclick="return confirm('Sure! You want to delete this rewind Cone Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                    <?php
                }

	}


	function view_loaded_beam ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
 | <a href="loaded_beam_edit.php?id=<?php echo $sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="loaded_beam_add_db.php?del=<?php echo $sno; ?>" onclick="return confirm('Sure! You want to delete this Loaded Beam Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                    <?php
                }

	}


		function view_towel ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
  | <a href="towel_delivery_summary_edit.php?id=<?php echo $sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="towel_delivery_summary_add_db.php?del=<?php echo $sno; ?>" onclick="return confirm('Sure! You want to delete this Towel Delivery Summary Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                    <?php
                }

	}


	function check_user ($user_role) {

		if(isset($_SESSION['role_id']) && $user_role=='3')
{
    echo '<script>window.location="dashboard.php"</script>';
    
}



	}


	function check_operator($user_role) {

		if(isset($_SESSION['role_id']) && $user_role=='2')
{
    echo '<script>window.location="dashboard.php"</script>';
    
}



	}

		function view_all_party ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
 | <a href="<?php echo 'party_edit.php?id='.$sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                    &nbsp;&nbsp;&nbsp;<a href="locations.php?id=<?php echo $sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-location-arrow" aria-hidden="true"></i></a>
                    | 
                    <a href="party_add_db.php?del=<?php echo $sno;?>" onclick="return confirm('Sure! You want to delete this Party Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>

                    <?php
                }

	}

		function view_wastage_sold ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>
 | <a href="wastage_sold_edit.php?id=<?php echo $sno; ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>
                  | 
                    <a href="wastage_sold_add_db.php?del=<?php echo $sno; ?>" onclick="return confirm('Sure! You want to delete this Wastage Sold Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}

		function view_brands ($sno) {
	 if(isset($_SESSION) && $_SESSION['role_id']==1)
                    {
?>|
   <a href="<?php echo 'brand_edit.php?id='.$sno ?>"  data-toggle="tooltip" data-original-title="Edit"><i class="fa fa-edit" aria-hidden="true"></i>
                  </a>
                  | 
                    <a href="brand_add_db.php?del=<?php echo $sno; ?>" onclick="return confirm('Sure! You want to delete this Brand Details')" data-toggle="tooltip" data-original-title="Delete" title="Delete">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </a>
                    <?php
                }

	}


	



	










function checkemail($str) {
	return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
}
// foreach ($_POST as $k => $v) {
// 	$_POST[$k]=str_replace("\r\n",'',str_replace("\r",'',str_replace("\n",'',str_replace("'",'&#39;',$v))));
// }

// foreach ($_GET as $k => $v) {
// 	$_GET[$k]=str_replace("\r\n",'',str_replace("\r",'',str_replace("\n",'',str_replace("'",'&#39;',$v))));
// }
$where='';
if (!isset($_GET['searchbig'])) $_GET['searchbig']='';
if (!isset($_GET['id'])) $_GET['id']='';
$stat1='';
$stat2='';
$sel0='';
$sel1='';
$sel2='';
$sel3='';
$search_res='';
$sc1='';
$sc2='';
$bgcolor='';
$content='';
$m='';
$f='';
$data='';
$tier='';
$brands='';
$city='';
$schools='';
$polls='';
$poll_set='';
$bid='';
$featured1='';
$featured2='';
$cat1='';
$cat2='';
$cat3='';
$designer='';
?>