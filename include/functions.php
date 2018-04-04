<?
/*-------------------------------------------------------------------------------
|| Name: send mail																||
|| Purpose: for sending email													||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function SendMail($to, $subject, $message, $headers = '')
{
	if( $headers == '' ) {
		$headers = "MIME-Version: 1.0\n" .
			"From: support@" . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])) . "\n" . 
			"Content-Type: text/html; charset=\"iso-8859-1\"\n";
	}

	return @mail($to, $subject, $message, $headers);
}

/*-------------------------------------------------------------------------------
|| Name: make thumbnail GD														||
|| Purpose: for making thumbnail of uploaded image thorugh GD library			||
|| this script will create a thumb nail in the same folder with prifix thumb_   ||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function make_thumb_gd ($input_file_name, $input_file_path,$rwid,$pref='thumb_')
{
	// makes a thumbnail using the GD library
	$quality = 72; // jpeg quality -- set in common.php

	// first, grab the dimensions of the pic
	$imagedata = getimagesize($input_file_path.'/'.$input_file_name);
	$imagewidth = $imagedata[0];
	$imageheight = $imagedata[1];
	$imagetype = $imagedata[2];
	
	// type definitions
	// 1 = GIF, 2 = JPG, 3 = PNG, 4 = SWF, 5 = PSD, 6 = BMP
	// 7 = TIFF(intel byte order), 8 = TIFF(motorola byte order)
	// 9 = JPC, 10 = JP2, 11 = JPX
	$thumb_name = $input_file_name; //by default
	// the GD library, which this uses, can only resize GIF, JPG and PNG

	if ($imagetype == 1)
	{
		// it's a GIF
		// figure out the ratio to which it should be shrunk, if at all
		// see if GIF support is enabled
		if (imagetypes() & IMG_GIF)
		{
			$shrinkage = 1;
			
			if($imagewidth>$imageheight)
			{
				if ($imagewidth > $rwid)
				{
					$shrinkage = $rwid/$imagewidth;
					$dest_width = $rwid;
				}
				else
				{
					$dest_width = $imagewidth;
				}
				
				$dest_height = $shrinkage * $imageheight;
			}
			else
			{
				if ($imageheight > $rwid)
				{
					$shrinkage = $rwid/$imageheight;
					$dest_height = $rwid;
				}
				else
				{
					$dest_height = $imageheight;
				}
				
				$dest_width = $shrinkage * $imagewidth;
			}	
			if($rwid==250)
			{
				$dest_width=250;
				$dest_height=236;
			}
			

			$src_img = imagecreatefromgif("$input_file_path/$input_file_name");
			$dst_img = imagecreatetruecolor($dest_width, $dest_height);

			//copy the original image info into the new image with new dimensions
			//checking to see which function is available

			imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);

			$thumb_name = "$pref"."$input_file_name";
			imagegif($dst_img, "$input_file_path/$thumb_name");
			imagedestroy($src_img);
			imagedestroy($dst_img);
		} // end if GIF support is enabled
	} // end if $imagetype == 1
	elseif ($imagetype == 2)
	{
		// it's a JPG
		// figure out the ratio to which it should be shrunk, if at all
		$shrinkage = 1;
		if($imagewidth>$imageheight)
		{
			if ($imagewidth > $rwid)
			{
				$shrinkage = $rwid/$imagewidth;
				$dest_width = $rwid;
			}
			else
			{
				$dest_width = $imagewidth;
			}
			
			$dest_height = $shrinkage * $imageheight;
		}
		else
		{
			if ($imageheight > $rwid)
			{
				$shrinkage = $rwid/$imageheight;
				$dest_height = $rwid;
			}
			else
			{
				$dest_height = $imageheight;
			}
			
			$dest_width = $shrinkage * $imagewidth;
		}	
		if($rwid==250)
		{
			$dest_width=250;
			$dest_height=236;
		}

		$src_img = imagecreatefromjpeg("$input_file_path/$input_file_name");

		$dst_img = imagecreatetruecolor($dest_width, $dest_height);
		
		//copy the original image info into the new image with new dimensions
		//checking to see which function is available
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $dest_width, $dest_height, $imagewidth, $imageheight);
		
		$thumb_name = "$pref"."$input_file_name";
		imagejpeg($dst_img, "$input_file_path/$thumb_name", $quality);
		imagedestroy($src_img);
		imagedestroy($dst_img);
	} // end if $imagetype == 2
	elseif ($imagetype == 3)
	{
		// it's a PNG
		// figure out the ratio to which it should be shrunk, if at all
		$shrinkage = 1;
		if($imagewidth>$imageheight)
		{
			if ($imagewidth > $rwid)
			{
				$shrinkage = $rwid/$imagewidth;
				$dest_width = $rwid;
			}
			else
			{
				$dest_width = $imagewidth;
			}
			
			$dest_height = $shrinkage * $imageheight;
		}
		else
		{
			if ($imageheight > $rwid)
			{
				$shrinkage = $rwid/$imageheight;
				$dest_height = $rwid;
			}
			else
			{
				$dest_height = $imageheight;
			}
			
			$dest_width = $shrinkage * $imagewidth;
		}	
		if($rwid==250)
		{
			$dest_width=250;
			$dest_height=236;
		}

		$src_img = imagecreatefrompng("$input_file_path/$input_file_name");
		$dst_img = imagecreatetruecolor($dest_width,$dest_height);
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $dest_width,$dest_height, $imagewidth, $imageheight);
		$thumb_name = "$pref"."$input_file_name";
		imagepng($dst_img, "$input_file_path/$thumb_name");
		imagedestroy($src_img);
		imagedestroy($dst_img);
	} // end if $imagetype == 3
	elseif ($imagetype == 6)
	{
		// it's a BMP
		// figure out the ratio to which it should be shrunk, if at all
		$shrinkage = 1;
		if($imagewidth>$imageheight)
		{
			if ($imagewidth > $rwid)
			{
				$shrinkage = $rwid/$imagewidth;
				$dest_width = $rwid;
			}
			else
			{
				$dest_width = $imagewidth;
			}
			
			$dest_height = $shrinkage * $imageheight;
		}
		else
		{
			if ($imageheight > $rwid)
			{
				$shrinkage = $rwid/$imageheight;
				$dest_height = $rwid;
			}
			else
			{
				$dest_height = $imageheight;
			}
			
			$dest_width = $shrinkage * $imagewidth;
		}	
		if($rwid==250)
		{
			$dest_width=250;
			$dest_height=236;
		}

		$src_img = imagecreatefromwbmp("$input_file_path/$input_file_name");
		$dst_img = imagecreatetruecolor($dest_width,$dest_height);
		imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $dest_width,$dest_height, $imagewidth, $imageheight);
		$thumb_name = "$pref"."$input_file_name";
		imagewbmp($dst_img, "$input_file_path/$thumb_name");
		imagedestroy($src_img);
		imagedestroy($dst_img);
	} // end if $imagetype == 6

} // end function make_thumb_gd

/*-------------------------------------------------------------------------------
|| Name: strip quote															||
|| Purpose: Quote variable to make safe 										||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function strip_quote($value) 
{ 
    // Stripslashes 
    if (get_magic_quotes_gpc()) { 
        $value = stripslashes($value); 
    } 
    return $value; 
}
/*-------------------------------------------------------------------------------
|| Name: add quote																||
|| Purpose: Quote variable to make safe 										||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function add_quote($value) 
{ 
    // Stripslashes 
    if (!get_magic_quotes_gpc()) { 
        $value = addslashes($value); 
    } 
    return $value; 
}

/*-------------------------------------------------------------------------------
|| Name: html entities															||
|| Purpose: Convert all applicable characters to HTML entities 					||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function html_entities($val)
{
	return htmlentities($val);
} 

/*-------------------------------------------------------------------------------
|| Name: check required															||
|| Purpose: to check madatory values in form				 					||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function checkRequired($post = array(), $required = array())
{
	$flag=false;

	for($i=0;$i<sizeof($required);$i++)
	{
		if(trim($post[$required[$i]]) == "")
		{
			$flag=true;
			break;
		}
	}
	return $flag;	
}

/*-------------------------------------------------------------------------------
|| Name: required Message														||
|| Purpose: to display message for madatory values in form	 					||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function requiredMessage($post = array(), $required = array())
{
	$missing = array();

	for($i=0;$i<sizeof($required);$i++)
	{
		if(trim($post[$required[$i]]) == "")
		{
			$missing[] = ucwords(str_replace("_"," ",$required[$i]));
		}
	}
	
	$include = implode(", ",$missing);

	$msg = "<div style=\"background-color:#fafafa;padding:2px;width:600px;\"><img src=\"images/error.png\" align=\"absmiddle\"><b><font color=\"#000\">Error: The following field(s) is/are required:</font></b> ".$include."</div><br>";

	return $msg;
}

/*-------------------------------------------------------------------------------
|| Name: required Message														||
|| Purpose: to display error messages						 					||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function displayErrMessage($msg)
{
	return "<div style=\"background-color:#fafafa;padding:2px;width:500px;\"><img src=\"images/error.png\" align=\"absmiddle\">&nbsp;<font color=\"#000\"><b>Error:</b>&nbsp; ".$msg."</font></div><br>";
}

/*-------------------------------------------------------------------------------
|| Name: display Message														||
|| Purpose: to display messages								 					||
|| Source: custom																||
|| Modified: 06/06/2008															||
--------------------------------------------------------------------------------*/
function displayMessage($msg)
{
	return "<div style=\"background-color:#f1f3f5;padding:2px;width:500px;\"><img src=\"images/ok.gif\" height=\"33\" align=\"absmiddle\">&nbsp;<font color=\"#3f7b09\"><b>Message:</b>&nbsp; ".$msg."</font></div>";
}

/*-------------------------------------------------------------------------------
|| Name: getMemberTypeArr														||
|| Purpose: to get member type								 					||
|| Source: custom																||
|| Modified: 08/14/2008															||
--------------------------------------------------------------------------------*/
function getMemberTypeArr()
{
	$memberTypeArr=array();
	$con=new dbcon;
	$sql="select member_type_id, member_type from ".DBPREFIX."member_type where active_status='Y'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$memberTypeArr[$rs["member_type_id"]]=$rs["member_type"];
	}
	return $memberTypeArr;
}

/*-------------------------------------------------------------------------------
|| Name: getMemberType														||
|| Purpose: to get member type								 					||
|| Source: custom																||
|| Modified: 08/14/2008															||
--------------------------------------------------------------------------------*/
function getMemberType($member_type_id)
{
	$member_type='';
	$con=new dbcon;
	$sql="select member_type from ".DBPREFIX."member_type where member_type_id=$member_type_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$member_type=$rs["member_type"];
	}
	return $member_type;
}

/*-------------------------------------------------------------------------------
|| Name: get Country Array													||
|| Purpose: to get Country Array											||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getCountryArr()
{
	$countryArr=array();
	
	$con=new dbcon;
	$sql="select country_id,country_title,code from ".DBPREFIX."country order by lower(country_title)";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$countryArr[$rs["country_id"]]=$rs["country_title"];
	}
	
	return $countryArr;
}

/*-------------------------------------------------------------------------------
|| Name: getStateArr															||
|| Purpose: get State Data														||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getStateArr($country_id)
{
	$stateArr=array();
	
	$con=new dbcon;
	$sql="select state_id,state_title from ".DBPREFIX."state where country_id=$country_id order by lower(state_title)";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$stateArr[$rs["state_id"]]=$rs["state_title"];
	}
	
	return $stateArr;	
}

/*-------------------------------------------------------------------------------
|| Name: getCityArr																||
|| Purpose: get City Data														||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getCityArr($country_id,$state_id)
{
	$cityArr=array();
	
	$con=new dbcon;
	$sql="select city_id,city_title from ".DBPREFIX."city where country_id=$country_id and state_id=$state_id order by lower(city_title)";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$cityArr[$rs["city_id"]]=$rs["city_title"];
	}
	
	return $cityArr;	
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantNameArr													||
|| Purpose: to get Restaurant Name 							 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantNameArr()
{
	$restaurantNameArr=array();
	$con=new dbcon;
	$sql="select restaurant_id,restaurant_name from ".DBPREFIX."restaurant";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantNameArr[$rs["restaurant_id"]]=$rs["restaurant_name"];
	}
	return $restaurantNameArr;
}

/*-------------------------------------------------------------------------------
|| Name: getRestaurantAddressArr												||
|| Purpose: to get Restaurant Address 						 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantAddressArr($restaurant_id)
{
	$restaurantAddressArr=array();
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."restaurant_address where restaurant_id='$restaurant_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantAddressArr=array("restaurant_id"=>$rs["restaurant_id"],"address"=>$rs["address"],"country_id"=>getCountryName($rs["country_id"]),"state_id"=>getStateName($rs["state_id"]),"city"=>$rs["city"],"zipcode"=>$rs["zipcode"],"phone"=>$rs["phone"]);
	}
	return $restaurantAddressArr;
}
/*-------------------------------------------------------------------------------
|| Name: getCountryName															||
|| Purpose: to get Country Name								 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getCountryName($country_id)
{
	$con=new dbcon;
	$sql="select country_title from ".DBPREFIX."country where country_id=$country_id";
	$con->Query($sql);	
	if($rs=$con->FetchAssoc())
	{
		$country_title=$rs["country_title"];
	}
	return $country_title;
}
/*-------------------------------------------------------------------------------
|| Name: getStateName															||
|| Purpose: to get State Name								 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getStateName($state_id)
{
	$con=new dbcon;
	$sql="select state_title from ".DBPREFIX."state where state_id=$state_id";
	$con->Query($sql);	
	if($rs=$con->FetchAssoc())
	{
		$state_title=$rs["state_title"];
	}
	return $state_title;
}
/*-------------------------------------------------------------------------------
|| Name: getCityName															||
|| Purpose: to get Country Name								 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getCityName($city_id)
{
	$con=new dbcon;
	$sql="select city_title from ".DBPREFIX."city where city_id=$city_id";
	$con->Query($sql);	
	if($rs=$con->FetchAssoc())
	{
		$city_title=$rs["city_title"];
	}
	return $city_title;
}

/*-------------------------------------------------------------------------------
|| Name: replace XMLChar														||
|| Purpose: to replace the XML Character by passing string as parameter			||
|| Source: custom																||
|| Modified: 27/08/2008															||
--------------------------------------------------------------------------------*/
function replaceXMLChar($str)
{
	if(ereg("&",$str))
	$str=ereg_replace("&","&amp;",$str);
	
	if(ereg("<",$str))
	$str=ereg_replace("<","&lt;",$str);
	
	if(ereg(">",$str))
	$str=ereg_replace(">","&gt;",$str);
	
	if(ereg("\"",$str))
	$str=ereg_replace("\"","&quot;",$str);
	
	if(ereg("'",$str))
	$str=ereg_replace("'","&apos;",$str);
	
	return($str);
}
/*-------------------------------------------------------------------------------
|| Name: getXMLStateArr															||
|| Purpose: get State Data														||
|| Source: custom																||
|| Modified: 27/08/2008															||
--------------------------------------------------------------------------------*/
function getXMLStateArr($country_id)
{
	$con=new dbcon;
	
	$str="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
	$str.="<DATA>\n";
	
	$sql="select state_id,state_title from ".DBPREFIX."state where country_id=$country_id order by lower(state_title)";
	$con->Query($sql);
	
	while($rs=$con->FetchRow())
	{
		$str.="<STATE>\n";
		$str.="<ID>".$rs["state_id"]."</ID>\n";
		$str.="<NAME>".replaceXMLChar($rs["state_title"])."</NAME>\n";
		$str.="</STATE>\n";
	}
	
	$str .="</DATA>\n";
	return $str;
}
/*-------------------------------------------------------------------------------
|| Name: getXMLCityArr															||
|| Purpose: get City Data														||
|| Source: custom																||
|| Modified: 17/09/2008															||
--------------------------------------------------------------------------------*/
function getXMLCityArr($country_id,$state_id)
{
	$con=new dbcon;
	
	$str="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
	$str.="<DATA>\n";
	
	$sql="select city_id,city_title from ".DBPREFIX."city where country_id=$country_id and state_id=$state_id order by lower(city_title)";
	$con->Query($sql);
	
	while($rs=$con->FetchRow())
	{
		$str.="<CITY>\n";
		$str.="<ID>".$rs["city_id"]."</ID>\n";
		$str.="<NAME>".replaceXMLChar($rs["city_title"])."</NAME>\n";
		$str.="</CITY>\n";
	}
	
	$str .="</DATA>\n";
	return $str;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisineArr															||
|| Purpose: to get Cuisine Name 							 					||
|| Source: custom																||
|| Modified: 27/08/2008															||
--------------------------------------------------------------------------------*/
function getCuisineArr()
{
	$cuisineArr=array();
	$con=new dbcon;
	$sql="select cuisine_id,cuisine from ".DBPREFIX."cuisine";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$cuisineArr[$rs["cuisine_id"]]=$rs["cuisine"];
	}
	return $cuisineArr;
}
/*-------------------------------------------------------------------------------
|| Name: getReservationArr														||
|| Purpose: to get Reservation Arr 							 					||
|| Source: custom																||
|| Modified: 27/08/2008															||
--------------------------------------------------------------------------------*/
function getReservationArr()
{
	$reservationArr=array();
	$con=new dbcon;
	$sql="select reservation_id,reservation from ".DBPREFIX."reservation";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$reservationArr[$rs["reservation_id"]]=$rs["reservation"];
	}
	return $reservationArr;
}
/*-------------------------------------------------------------------------------
|| Name: getPriceRangeArr														||
|| Purpose: to get price range	 							 					||
|| Source: custom																||
|| Modified: 27/08/2008															||
--------------------------------------------------------------------------------*/
function getPriceRangeArr()
{
	$priceRangeArr=array();
	$con=new dbcon;
	$sql="select price_range_id,price_range from ".DBPREFIX."price_range";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$priceRangeArr[$rs["price_range_id"]]=$rs["price_range"];
	}
	return $priceRangeArr;
}
/*-------------------------------------------------------------------------------
|| Name: getPaymentOptionArr													||
|| Purpose: to get Payment Option 							 					||
|| Source: custom																||
|| Modified: 03/09/2008															||
--------------------------------------------------------------------------------*/
function getPaymentOptionArr()
{
	$paymentOptionArr=array();
	$con=new dbcon;
	$sql="select payment_option_id,payment_option from ".DBPREFIX."payment_option";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$paymentOptionArr[$rs["payment_option_id"]]=$rs["payment_option"];
	}
	return $paymentOptionArr;
}

/*-------------------------------------------------------------------------------
|| Name: getRestaurantPaymentOptionArr											||
|| Purpose: to get Restaurant Payment Option 							 		||
|| Source: custom																||
|| Modified: 03/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantPaymentOptionArr($restaurant_id)
{
	$restaurantPaymentOptionArr=array();
	$con=new dbcon;
	$sql="select payment_option_id from ".DBPREFIX."restaurant_payment_option where restaurant_id=$restaurant_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantPaymentOptionArr[]=$rs["payment_option_id"];
	}
	return $restaurantPaymentOptionArr;
}

/*-------------------------------------------------------------------------------
|| Name: getMealServedArr														||
|| Purpose: to get Meal Served Option 									 		||
|| Source: custom																||
|| Modified: 03/09/2008															||
--------------------------------------------------------------------------------*/
function getMealServedArr()
{
	$mealServedArr=array();
	$con=new dbcon;
	$sql="select meal_served_id,meal_served from ".DBPREFIX."meal_served";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$mealServedArr[$rs["meal_served_id"]]=$rs["meal_served"];
	}
	return $mealServedArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantMealServedArr												||
|| Purpose: to get Restaurant Meal Served Option 						 		||
|| Source: custom																||
|| Modified: 03/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantMealServedArr($restaurant_id)
{
	$restaurantMealServedArr=array();
	$con=new dbcon;
	$sql="select meal_served_id from ".DBPREFIX."restaurant_meal_served where restaurant_id=$restaurant_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantMealServedArr[]=$rs["meal_served_id"];
	}
	return $restaurantMealServedArr;
}
/*-------------------------------------------------------------------------------
|| Name: getWeddingHallAddressArr												||
|| Purpose: to get Wedding Hall Address						 					||
|| Source: custom																||
|| Modified: 04/09/2008															||
--------------------------------------------------------------------------------*/
function getWeddingHallAddressArr($wedding_hall_id)
{
	$weddingHallAddressArr=array();
	$con=new dbcon;
    $sql="select * from ".DBPREFIX."wedding_hall_address where wedding_hall_id='$wedding_hall_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$weddingHallAddressArr=array("address"=>$rs["address"],"country_id"=>getCountryName($rs["country_id"]),"state_id"=>getStateName($rs["state_id"]),"city"=>$rs["city"],"zipcode"=>$rs["zipcode"],"phone"=>$rs["phone"]);
	}
	return $weddingHallAddressArr;
}
/*-------------------------------------------------------------------------------
|| Name: getWeddingHallNameArr													||
|| Purpose: to get Wedding Hall Name						 					||
|| Source: custom																||
|| Modified: 04/09/2008															||
--------------------------------------------------------------------------------*/
function getWeddingHallNameArr()
{
	$weddingHallNameArr=array();
	$con=new dbcon;
	$sql="select wedding_hall_id,wedding_hall_name from ".DBPREFIX."wedding_hall";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$weddingHallNameArr[$rs["wedding_hall_id"]]=$rs["wedding_hall_name"];
	}
	return $weddingHallNameArr;
}
/*-------------------------------------------------------------------------------
|| Name: getServiceArr															||
|| Purpose: to get services in manage wedding hall section						||
|| Source: custom																||
|| Modified: 05/09/2008															||
--------------------------------------------------------------------------------*/
function getServiceArr()
{
	$serviceArr=array();
	
	$con=new dbcon;
	$sql="select service_id,service_title from ".DBPREFIX."service order by lower(service_title )";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$serviceArr[$rs["service_id"]]=$rs["service_title"];
	}
	
	return $serviceArr;
}
/*-------------------------------------------------------------------------------
|| Name: getFacilityArr															||
|| Purpose: to get facility in manage wedding hall section						||
|| Source: custom																||
|| Modified: 05/09/2008															||
--------------------------------------------------------------------------------*/
function getFacilityArr()
{
	$facilityArr=array();
	
	$con=new dbcon;
	$sql="select facility_id,facility_title from ".DBPREFIX."facility";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$facilityArr[$rs["facility_id"]]=$rs["facility_title"];
	}
	
	return $facilityArr;
}
/*-------------------------------------------------------------------------------
|| Name: getXMLUploadDataArr													||
|| Purpose: get photo upload Data												||
|| Source: custom																||
|| Modified: 08/09/2008															||
--------------------------------------------------------------------------------*/
function getXMLUploadDataArr($type)
{
	$con=new dbcon;	
	$str="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
	$str.="<DATA>\n";
	switch($type)
	{
		case 'R':				
		$sql="select restaurant_id,restaurant_name from ".DBPREFIX."restaurant order by lower(restaurant_name)";
		$con->Query($sql);
		while($rs=$con->FetchRow())
		{
			$str.="<STATE>\n";
			$str.="<ID>".$rs["restaurant_id"]."</ID>\n";
			$str.="<NAME>".replaceXMLChar($rs["restaurant_name"])."</NAME>\n";
			$str.="</STATE>\n";
		}								
		break;
		case 'W':
		$sql="select wedding_hall_id,wedding_hall_name from ".DBPREFIX."wedding_hall order by lower(wedding_hall_name)";
		$con->Query($sql);
		while($rs=$con->FetchRow())
		{
			$str.="<STATE>\n";
			$str.="<ID>".$rs["wedding_hall_id"]."</ID>\n";
			$str.="<NAME>".replaceXMLChar($rs["wedding_hall_name"])."</NAME>\n";
			$str.="</STATE>\n";
		}										
		break;	
		case 'H':				
		break;
		case 'C':				
		break;			
	}
	$str .="</DATA>\n";
	return $str;
}
/*-------------------------------------------------------------------------------
|| Name: getRWPicture															||
|| Purpose: to get Photo Name								 					||
|| Source: custom																||
|| Modified: 09/09/2008															||
--------------------------------------------------------------------------------*/
function getRWPicture($type,$id)
{
	$photo_name=array();
	$con=new dbcon;
	switch($type)
	{
		case 'R':				
		$sql="select restaurant_photo_id,photo_name from ".DBPREFIX."restaurant_photo where restaurant_id=$id";
		$con->Query($sql);
		while($rs=$con->FetchRow())
		{
			$photo_name[$rs["restaurant_photo_id"]]=$rs["photo_name"];
		}
									
		break;
		
		case 'W':
		$sql="select wedding_hall_photo_id,photo_name from ".DBPREFIX."wedding_hall_photo where wedding_hall_id=$id";
		$con->Query($sql);
		while($rs=$con->FetchRow())
		{
			$photo_name[$rs["wedding_hall_photo"]]=$rs["photo_name"];
		}
										
		break;	
		case 'H':	
		$sql="select hotel_photo_id,photo_name from ".DBPREFIX."hotel_photo where hotel_id=$id";
		$con->Query($sql);
		while($rs=$con->FetchRow())
		{
			$photo_name[$rs["hotel_photo_id"]]=$rs["photo_name"];
		}
							
		break;
		case 'C':				
		break;			
	}	
	return $photo_name;		
}
/*-------------------------------------------------------------------------------
|| Name: getMenuCategoryArr														||
|| Purpose: to get Menu Category 							 					||
|| Source: custom																||
|| Modified: 10/09/2008															||
--------------------------------------------------------------------------------*/
function getMenuCategoryArr()
{
	$menuCategoryArr=array();
	$con=new dbcon;
	$sql="select menu_category_id,category_name from ".DBPREFIX."menu_category";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$menuCategoryArr[$rs["menu_category_id"]]=$rs["category_name"];
	}
	return $menuCategoryArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestautantMenu														||
|| Purpose: to get Menu Name	 							 					||
|| Source: custom																||
|| Modified: 10/09/2008															||
--------------------------------------------------------------------------------*/
function getRestautantMenu($restaurant_id)
{
	$con=new dbcon;
	$sql="select restaurant_menu_id,menu_name from ".DBPREFIX."restaurant_menu where restaurant_id=$restaurant_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$menuName=$rs["menu_name"];
	}
	return $menuName;
}

/*-------------------------------------------------------------------------------
|| Name: getXMLRestarantMenu													||
|| Purpose: get XML Restarant Menu 							 					||
|| Source: custom																||
|| Modified: 10/09/2008															||
--------------------------------------------------------------------------------*/
function getXMLRestarantMenu($restaurant_id,$menu_category_id,$meal_served_id)
{
	$con=new dbcon;	
	$str="<?xml version=\"1.0\" encoding=\"iso-8859-1\"?>\n";
	$str.="<DATA>\n";
			
	$sql="select restaurant_menu_id, menu_name, description, additional_info, price, menu_url, status from ".DBPREFIX."restaurant_menu where restaurant_id=$restaurant_id";
	
	if($menu_category_id!="")
	{
		$sql.=" and menu_category_id=$menu_category_id";
	}
	
	if($meal_served_id!="")
	{
		$sql.=" and meal_served_id=$meal_served_id";
	}
	
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$str.="<MENU>\n";
		$str.="<MENUID>".$rs["restaurant_menu_id"]."</MENUID>\n";
		$str.="<MENUNAME>".replaceXMLChar($rs["menu_name"])."</MENUNAME>\n";
		$str.="<DESCRIPTION>".replaceXMLChar($rs["description"])."</DESCRIPTION>\n";
		$str.="<ADDITIONALINFO>".replaceXMLChar($rs["additional_info"])."</ADDITIONALINFO>\n";
		$str.="<PRICE>".replaceXMLChar($rs["price"])."</PRICE>\n";
		$str.="<MENUURL>".replaceXMLChar($rs["menu_url"])."</MENUURL>\n";
		$str.="<STATUS>".replaceXMLChar($rs["status"])."</STATUS>\n";
		$str.="</MENU>\n";
	}								
	
	$str .="</DATA>\n";
	return $str;	
}
/*-------------------------------------------------------------------------------
|| Name: getHotelVideoTitleArr													||
|| Purpose: to get Hotel Video Tirle						 					||
|| Source: custom																||
|| Modified: 17/09/2008															||
--------------------------------------------------------------------------------*/
function getHotelVideoTitleArr()
{
	$hotelVideoTitleArr=array();
	$con=new dbcon;
	$sql="select hotel_video_id,hotel_video_title from ".DBPREFIX."hotel_video";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$hotelVideoTitleArr[$rs["hotel_video_id"]]=$rs["hotel_video_title"];
	}
	return $hotelVideoTitleArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantTypeArr													||
|| Purpose: to get Restaurant type 							 					||
|| Source: custom																||
|| Modified: 19/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantTypeArr()
{
	$restaurantTypeArr=array();
	$con=new dbcon;
	$sql="select restaurant_type_id,business_type from ".DBPREFIX."restaurant_types";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantTypeArr[$rs["restaurant_type_id"]]=$rs["business_type"];
	}
	return $restaurantTypeArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantFeatureArr												||
|| Purpose: to get Restaurant Feature						 					||
|| Source: custom																||
|| Modified: 19/09/2008															||
--------------------------------------------------------------------------------*/
function getFeatureArr()
{
	$featureArr=array();
	$con=new dbcon;
	$sql="select feature_id,feature_title from ".DBPREFIX."feature";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$featureArr[$rs["feature_id"]]=$rs["feature_title"];
	}
	return $featureArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantFeatureArr												||
|| Purpose: to get Restaurant Feature									 		||
|| Source: custom																||
|| Modified: 19/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantFeatureArr($restaurant_id)
{
	$restaurantFeatureArr=array();
	$con=new dbcon;
	$sql="select feature_id from ".DBPREFIX."restaurant_feature where restaurant_id=$restaurant_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantFeatureArr[]=$rs["feature_id"];
	}
	return $restaurantFeatureArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantMenu														||
|| Purpose: to get Restaurant Menu										 		||
|| Source: custom																||
|| Modified: 24/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantMenu($restaurant_id)
{
	$restaurantMenuArr=array();
	$con=new dbcon;	
	$sql="SELECT distinct S.meal_served_id, S.meal_served, C.menu_category_id, C.category_name FROM ".DBPREFIX."restaurant_menu M inner join ".DBPREFIX."meal_served S on S.meal_served_id=M.meal_served_id inner join ".DBPREFIX."menu_category C on M.menu_category_id=C.menu_category_id where restaurant_id=$restaurant_id and M.status='Y' order by S.meal_served, C.category_name";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantMenuArr[]=array("restaurant_id"=>$restaurant_id,"meal_served_id"=>$rs["meal_served_id"],"meal_served"=>$rs["meal_served"],"menu_category_id"=>$rs["menu_category_id"],"category_name"=>$rs["category_name"]);
	}
	return $restaurantMenuArr;
}

/*-------------------------------------------------------------------------------
|| Name: getRestaurantMenu														||
|| Purpose: to get Restaurant Menu										 		||
|| Source: custom																||
|| Modified: 24/09/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantMenuItem($restaurant_id,$meal_served_id,$menu_category_id)
{
	$restaurantMenuArr=array();
	$con=new dbcon;	
	$sql="SELECT M.restaurant_menu_id, M.menu_name, M.description, M.additional_info, M.price FROM ".DBPREFIX."restaurant_menu M inner join ".DBPREFIX."meal_served S on S.meal_served_id=M.meal_served_id inner join ".DBPREFIX."menu_category C on M.menu_category_id=C.menu_category_id where restaurant_id=$restaurant_id and M.status='Y' and S.meal_served_id=$meal_served_id and C.menu_category_id=$menu_category_id order by M.menu_name";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$restaurantMenuArr[]=array("menu_name"=>$rs["menu_name"],"description"=>$rs["description"],"additional_info"=>$rs["additional_info"],"price"=>$rs["price"]);
	}
	return $restaurantMenuArr;
}
/*-------------------------------------------------------------------------------
|| Name: getSecretQuestionArr													||
|| Purpose: get SecretQuestion Data												||
|| Source: custom																||
|| Modified: 25/09/2008															||
--------------------------------------------------------------------------------*/
function getSecretQuestionArr()
{
	$SecretQuestionyArr=array();
	
	$con=new dbcon;
	$sql="select secretquestion_id,question from ".DBPREFIX."secretquestion order by secretquestion_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$SecretQuestionyArr[$rs["secretquestion_id"]]=$rs["question"];
	}
	
	return $SecretQuestionyArr;	
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantTypeName													||
|| Purpose: to get Restaurant Type Name						 					||
|| Source: custom																||
|| Modified: 29/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantTypeName($restaurantTypeArr)
{
	$restaurantType=array();	
	foreach($restaurantTypeArr as $value)
	{
		$con=new dbcon;
		$sql="select business_type,restaurant_type_id from ".DBPREFIX."restaurant_types where restaurant_type_id=$value";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$restaurantType[]=$rs["business_type"];
		}
	}	
	return $restaurantType;	
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantPriceRange												||
|| Purpose: to get Restaurant Price Range					 					||
|| Source: custom																||
|| Modified: 29/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantPriceRange($restaurant_id)
{
	$con=new dbcon;
	$sql="select price_range_id from ".DBPREFIX."restaurant_price_range  where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$RestaurantPriceRange=getRestaurantPriceRangeName($rs["price_range_id"]);
	}
	return $RestaurantPriceRange;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantTypeName													||
|| Purpose: to get Restaurant Type Name						 					||
|| Source: custom																||
|| Modified: 29/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantPriceRangeName($price_range_id)
{
	$con=new dbcon;
	$sql="select price_range from ".DBPREFIX."price_range where price_range_id=$price_range_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$PriceRangeName=$rs["price_range"];
	}
	return $PriceRangeName;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantPhoto														||
|| Purpose: to get Restaurant Photo Name					 					||
|| Source: custom																||
|| Modified: 29/08/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantPhoto($restaurant_id)
{
	$con=new dbcon;
	$sql="select photo_name from ".DBPREFIX."restaurant_photo  where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$photo_name=$rs["photo_name"];
	}
	return $photo_name;
}
/*-------------------------------------------------------------------------------
|| Name: getWeddingHallPhoto													||
|| Purpose: to get Wedding Hall Photo Name					 					||
|| Source: custom																||
|| Modified: 30/08/2008															||
--------------------------------------------------------------------------------*/
function getWeddingHallPhoto($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select photo_name from ".DBPREFIX."wedding_hall_photo  where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$photo_name=$rs["photo_name"];
	}
	return $photo_name;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisine																||
|| Purpose: to get Cuisine									 					||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getCuisine($restaurant_id)
{	
	$con=new dbcon;
	$sql="select cuisine_id from ".DBPREFIX."restaurant_cuisine  where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$cuisine=getCuisineName(explode(",",$rs["cuisine_id"]));
	}	
	return $cuisine;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisineName															||
|| Purpose: to get Cuisine Name													||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getCuisineName($cuisine_id)
{
	$cuisineName=array();
	foreach($cuisine_id as $value)
	{
		$con=new dbcon;
		$sql="select cuisine from ".DBPREFIX."cuisine where cuisine_id=$value";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
			$cuisineName[]=$rs["cuisine"];
		}
	}			
	return $cuisineName;
}
/*-------------------------------------------------------------------------------
|| Name: getReservation															||
|| Purpose: to get reservation								 					||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getReservation($restaurant_id)
{
	$con=new dbcon;
	$sql="select reservation_id from ".DBPREFIX."restaurant_reservation  where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$reservation=getReservationName($rs["reservation_id"]);
	}
	return $reservation;
}
/*-------------------------------------------------------------------------------
|| Name: getReservationName														||
|| Purpose: to get Reservation Name												||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getReservationName($reservation_id)
{
	$con=new dbcon;
	$sql="select reservation from ".DBPREFIX."reservation where reservation_id=$reservation_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$reservationName=$rs["reservation"];
	}
	return $reservationName;
}
/*-------------------------------------------------------------------------------
|| Name: getPaymentOptionArr													||
|| Purpose: to get payment option							 					||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getPaymentOption($restaurant_id)
{
	$paymentOptionArr=array();
	
	$con=new dbcon;
	$sql="select payment_option_id from ".DBPREFIX."restaurant_payment_option  where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$paymentOptionArr[]=getPaymentOptionName($rs["payment_option_id"]);
	}	
	return $paymentOptionArr;
}
/*-------------------------------------------------------------------------------
|| Name: getReservationName														||
|| Purpose: to get Reservation Name												||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getPaymentOptionName($payment_option_id)
{
	$con=new dbcon;
	$sql="select payment_option from ".DBPREFIX."payment_option where payment_option_id=$payment_option_id ";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$payment_option_Name=$rs["payment_option"];
	}
	return $payment_option_Name;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantRating													||
|| Purpose: to get Reservation Name												||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantRating($restaurant_id,$member_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."restaurant_rating where restaurant_id=$restaurant_id and member_id=$member_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantName														||
|| Purpose: to get Restaurnt Name												||
|| Source: custom																||
|| Modified: 07/10/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantName($restaurant_id)
{
	$con=new dbcon;
	$sql="select restaurant_name from ".DBPREFIX."restaurant where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$restaurantName=$rs["restaurant_name"];
	}
	return $restaurantName;
}
/*-------------------------------------------------------------------------------
|| Name: getWeddingHallName														||
|| Purpose: to get Wedding Hall Name											||
|| Source: custom																||
|| Modified: 08/10/2008															||
--------------------------------------------------------------------------------*/
function getWeddingHallName($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select wedding_hall_name from ".DBPREFIX."wedding_hall where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$weddingHallName=$rs["wedding_hall_name"];
	}
	return $weddingHallName;
}
/*-------------------------------------------------------------------------------
|| Name: getCountPicture														||
|| Purpose: to get Count Picture												||
|| Source: custom																||
|| Modified: 07/10/2008															||
--------------------------------------------------------------------------------*/
function getCountPicture($restaurant_id)
{
	$con=new dbcon;
	$sql="select count(photo_name) as count_picture from ".DBPREFIX."restaurant_photo where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$countPicture=$rs["count_picture"];
	}
	return $countPicture;
}
/*-------------------------------------------------------------------------------
|| Name: getCountPicture														||
|| Purpose: to get Count Picture												||
|| Source: custom																||
|| Modified: 07/10/2008															||
--------------------------------------------------------------------------------*/
function getWeddingHallCountPicture($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select count(photo_name) as count_picture from ".DBPREFIX."wedding_hall_photo where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$countPicture=$rs["count_picture"];
	}
	return $countPicture;
}
/*-------------------------------------------------------------------------------
|| Name: getLeftNav																||
|| Purpose: to get leftnav option												||
|| Source: custom																||
|| Modified: 13/10/2008	, 20/10/2008											||
--------------------------------------------------------------------------------*/
function getLeftNav($value)
{
	$con=new dbcon;
	switch($value)
	{
		case '0':				
		$sql="select count(restaurant_id) as restaurant from ".DBPREFIX."restaurant";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["restaurant"];
		}									
		break;
		
		case '1':
		$sql="SELECT * FROM ".DBPREFIX."restaurant_cuisine";
		$con->Query($sql);		
		while($rs=$con->FetchRow())
		{
			$getcuisineArr[]=$rs["cuisine_id"];
		}
		$arr=array();
		foreach($getcuisineArr as $item)
		{
			$array=getCuisineName(explode(",",$item));
			foreach($array as $item2)
			{
				$arr[]=$item2;
				$count=count(array_unique($arr));;
			}					
		}									
		break;	
		
		case '2':
		$sql="select restaurant_id, restaurant_name, (
SELECT avg(rating) FROM ".DBPREFIX."restaurant_rating where restaurant_id=R.restaurant_id group by restaurant_id) avg_rating from ".DBPREFIX."restaurant R order by  avg_rating desc limit 0,5";
		$con->Query($sql);	
		$count=$con->NumRow();						
		break;	
		
		case '3':
		$sql="select count(restaurant_id) as restaurant from ".DBPREFIX."member_favourites where member_id=$_SESSION[USER_MEMBER_ID]";
		
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["restaurant"];
		}							
		break;	
		
		case '4':
		$sql="select count(restaurant_id) as restaurant from ".DBPREFIX."member_wishlist where member_id=$_SESSION[USER_MEMBER_ID]";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["restaurant"];
		}						
		break;	
		
		case '5':
		$sql="select count(restaurant_id) as restaurant from ".DBPREFIX."member_beenthere where member_id=$_SESSION[USER_MEMBER_ID]";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["restaurant"];
		}						
		break;	
		
		case '6':
		$sql="select count(hotel_id) as hotel from ".DBPREFIX."hotel_member_favourites where member_id=$_SESSION[USER_MEMBER_ID]";
		
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["hotel"];
		}							
		break;
		
		case '7':
		$sql="select count(hotel_id) as hotel from ".DBPREFIX."hotel_member_wishlist where member_id=$_SESSION[USER_MEMBER_ID]";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["hotel"];
		}						
		break;		
		
		case '8':
		$sql="select count(hotel_id) as hotel from ".DBPREFIX."hotel_member_beenthere where member_id=$_SESSION[USER_MEMBER_ID]";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["hotel"];
		}						
		break;	
		
		case '10':
		$sql="select count(wedding_hall_id) as wedding_hall from ".DBPREFIX."wedding_hall_member_wishlist where member_id=$_SESSION[USER_MEMBER_ID]";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["wedding_hall"];
		}						
		break;	
								
	}	
	return $count;
}
/*-------------------------------------------------------------------------------
|| Name: getRightNav															||
|| Purpose: to get rightnav														||
|| Source: custom																||
|| Modified: 13/10/2008															||
--------------------------------------------------------------------------------*/
function getRightNav()
{
 	$rightNavArr=array();
	
	$con=new dbcon;
	$sql="select restaurant_id,restaurant_name from ".DBPREFIX."restaurant order By created_date desc limit 0,10";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rightNavArr[$rs["restaurant_id"]]=$rs["restaurant_name"];
	}	
	return $rightNavArr;
}

/*-------------------------------------------------------------------------------
|| Name: getpopularrestaurant													||
|| Purpose: to get popular restaurants											||
|| Source: custom																||
|| Modified: 15/10/2008															||
--------------------------------------------------------------------------------*/
function getPopularRestaurant()
{
	$PopularRestaurantArr=array();
	$con=new dbcon;
	$sql="select restaurant_id, restaurant_name, (
SELECT avg(rating) FROM ".DBPREFIX."restaurant_rating where restaurant_id=R.restaurant_id group by restaurant_id) avg_rating from ".DBPREFIX."restaurant R order by  avg_rating desc limit 0,5";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$PopularRestaurantArr[]=array("restaurant_id"=>$rs["restaurant_id"],"restaurant_name"=>$rs["restaurant_name"]);
	}
	return $PopularRestaurantArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantSearchRating												||
|| Purpose: to get Reservation Name												||
|| Source: custom																||
|| Modified: 16/10/2008															||
--------------------------------------------------------------------------------*/
function getRestaurantSearchRating($restaurant_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."restaurant_rating where restaurant_id=$restaurant_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisineNumbers											            ||
|| Purpose: to get corresponding cuisine number									||
|| Source: custom																||
|| Modified: 16/10/2008															||
--------------------------------------------------------------------------------*/
function getCuisineNumbers($value)
{
	$con=new dbcon;
	$sql="select count(*) as cuisine_count from ".DBPREFIX."restaurant_cuisine where (cuisine_id like '$value' or cuisine_id like '$value,%' or cuisine_id like '%,$value,%' or cuisine_id like '%,$value')";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$cuisine_count=$rs["cuisine_count"];
	}										
	return $cuisine_count;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisineId												            ||
|| Purpose: to get corresponding cuisine ID										||
|| Source: custom																||
|| Modified: 16/10/2008															||
--------------------------------------------------------------------------------*/
function getCuisineId($value)
{
	$con=new dbcon;
	$sql="select cuisine_id from ".DBPREFIX."cuisine where cuisine like '$value'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$cuisine_id=$rs["cuisine_id"];
	}										
	return $cuisine_id;
}
/*-------------------------------------------------------------------------------
|| Name: getCuisineNameId											            ||
|| Purpose: to get corresponding cuisine ID										||
|| Source: custom																||
|| Modified: 16/10/2008															||
--------------------------------------------------------------------------------*/
function getCuisineNameId($cuisine_id)
{
	$con=new dbcon;
	$sql="select cuisine from ".DBPREFIX."cuisine where cuisine_id=$cuisine_id";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$cuisine=$rs["cuisine"];
	}										
	return $cuisine;
}
/*-------------------------------------------------------------------------------
|| Name: invitefriend											                ||
|| Purpose: to send mail to a friend										    ||
|| Source: custom																||
|| Modified: 3/11/2008															||
--------------------------------------------------------------------------------*/
function invitefriends()
{
	$smarty = new Smarty_RoomsMenus();


	if($_REQUEST["task"]=="send")
	{	
		$name = $_REQUEST["name"];
		$to = $_REQUEST["email"];
		if($_SESSION["USER_USERNAME"])
		$subject = 'Invitation from '.$_SESSION["USER_USERNAME"].' to see Rooms & Menus'; 
		else
		$subject = 'Invitation from '.$name.' to see Rooms & Menus';
		
		$message = $_REQUEST["message"];
		$messagelink = $_REQUEST["messagelink"];
		
		if($_SESSION["USER_USERNAME"])
		$headers = "MIME-Version: 1.0\n" .
			"From: " .$_SESSION["USER_USERNAME"]."@" . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])). "\n" . 
			"Content-Type: text/html; charset=\"iso-8859-1\"\n";
			else
			$headers = "MIME-Version: 1.0\n" .
			"From: ".$name."@" . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME'])) . "\n" . 
			"Content-Type: text/html; charset=\"iso-8859-1\"\n";
		
		$message= str_replace($messagelink,'<a href="'.$messagelink.'">'.$messagelink.'</a>',$message);
		if(!ereg("http",$message))
		$message.=' <a href="'.$messagelink.'">'.$messagelink.'</a>';
		/*echo $to;
		echo $subject;
		echo $message;
		echo $headers;	
		die;*/
		$mail_sent = @mail( $to, $subject, $message, $headers );		
		$msg=displayMessage("Mail Sent...!!");
		$smarty->assign('msg',$msg);
	}
		$smarty->assign('url','http://'.$_SERVER['SERVER_NAME'].$_SESSION[inviteurl]);
		$smarty->display('invitefriends.tpl');
	
}
/*-------------------------------------------------------------------------------
|| Name: getRightNavresttype											        ||
|| Purpose: to show restaurant type in right navigator						    ||
|| Source: custom																||
|| Modified: 13/11/2008															||
--------------------------------------------------------------------------------*/
function getRightNavresttype($restaurant_id)
{
 	$rightNav=array();
	
	$con=new dbcon;
	$sql="SELECT A.restaurant_id, A.restaurant_name, B.business_type
			FROM rm_restaurant A
			INNER JOIN rm_restaurant_types B ON A.restaurant_type_id = B.restaurant_type_id and 			A.restaurant_id=$restaurant_id
			ORDER BY created_date desc
			LIMIT 0 , 10";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rightNav[$rs["restaurant_id"]]=$rs["business_type"];
	}	
	return $rightNav;
}
/*-------------------------------------------------------------------------------
|| Name: getleftpicture											                ||
|| Purpose: to show picture in left navigator						            ||
|| Source: custom																||
|| Modified: 13/11/2008															||
--------------------------------------------------------------------------------*/
function getleftpicture()
{	

	$member_id=$_SESSION["USER_MEMBER_ID"];
	$con=new dbcon;
	$sql="select myphoto from ".DBPREFIX."members where member_id='$member_id'";
	$con->Query($sql);
	$rs=$con->FetchRow();
	return $rs["myphoto"];	
}
/*-------------------------------------------------------------------------------
|| Name: loginmsg											                    ||
|| Purpose: to shoe login or sign up message						            ||
|| Source: custom																||
|| Modified: 13/11/2008															||
--------------------------------------------------------------------------------*/
function loginmsg()
{	
$smarty = new Smarty_RoomsMenus();
$smarty->display('main.loginmsg.tpl');		
}
/*-------------------------------------------------------------------------------
|| Name: submitpost											                    ||
|| Purpose: to post review										                ||
|| Source: custom																||
|| Modified: 07/01/2009														    ||
--------------------------------------------------------------------------------*/
function submitpost()
{
	$smarty = new Smarty_RoomsMenus();	
	$restaurant_id=$_REQUEST["restaurant_id"];
	$hotel_id=$_REQUEST["hotel_id"];
	$wedding_hall_id=$_REQUEST["wedding_hall_id"];
	
	if($_REQUEST["task"]=="send" && $_REQUEST["restaurant_id"]!='')
	{
	
	$member_id=$_SESSION["USER_MEMBER_ID"];
	$submitpost=html_entities($_POST["submitpost"]);
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."restaurant_review where member_id=$member_id and 						restaurant_id=$restaurant_id";
	$con->Query($sql);
		if($con->NumRow()>0)
		{
		$sql="update ".DBPREFIX."restaurant_review set restaurant_id='$restaurant_id',member_id='$member_id',comment='$submitpost',created_date=now() where member_id=$member_id and restaurant_id=$restaurant_id ";
		$con->Query($sql);
		}
		else
		{
		$sql="insert into ".DBPREFIX."restaurant_review(restaurant_id,member_id,comment,created_date) 		VALUES ('$restaurant_id',$member_id,'$submitpost',now())";
		$con->Query($sql);
	}
	
	}	
	
	
	if($_REQUEST["task"]=="send" && $_REQUEST["hotel_id"]!='')
	{
	
	$member_id=$_SESSION["USER_MEMBER_ID"];
	$submitpost=html_entities($_POST["submitpost"]);
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."hotel_review where member_id=$member_id and hotel_id=$hotel_id";
	$con->Query($sql);
		if($con->NumRow()>0)
		{
		$sql="update ".DBPREFIX."hotel_review set hotel_id='$hotel_id',member_id='$member_id',comment='$submitpost',created_date=now() where member_id=$member_id and hotel_id=$hotel_id ";
		$con->Query($sql);
		}
		else
		{
		$sql="insert into ".DBPREFIX."hotel_review(hotel_id,member_id,comment,created_date) VALUES ('$hotel_id',$member_id,'$submitpost',now())";
	$con->Query($sql);
		}

	}
		if($_REQUEST["task"]=="send" && $_GET["wedding_hall_id"]!='')
	{
	
	$member_id=$_SESSION["USER_MEMBER_ID"];
	$submitpost=html_entities($_POST["submitpost"]);
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."wedding_hall_review where member_id=$member_id and 						wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);
		if($con->NumRow()>0)
		{
		$sql="update ".DBPREFIX."wedding_hall_review set wedding_hall_id='$wedding_hall_id',member_id='$member_id',comment='$submitpost',created_date=now() where member_id=$member_id and wedding_hall_id=$wedding_hall_id ";
		$con->Query($sql);
		}
		else
		{
		$sql="insert into ".DBPREFIX."wedding_hall_review(wedding_hall_id,member_id,comment,created_date) VALUES ('$wedding_hall_id',$member_id,'$submitpost',now())";
		$con->Query($sql);
	}
	
	}	
		$smarty->assign('hotel_id',$hotel_id);
		$smarty->assign('restaurant_id',$restaurant_id);
		$smarty->assign('wedding_hall_id',$wedding_hall_id);	
		$smarty->display('main.submitpost.tpl');
	
}
/*-------------------------------------------------------------------------------
|| Name: reviews										                        ||
|| Purpose: to show reviews						                                ||
|| Source: custom																||
|| Modified: 08/01/2009	, 06/02/2009														||
--------------------------------------------------------------------------------*/
function reviews($value)
{	
    $smarty = new Smarty_RoomsMenus();	
	$con=new dbcon;
	$review=array ();
	$restaurant_id=$_REQUEST["restaurant_id"];
	$hotel_id=$_REQUEST["hotel_id"];
	$wedding_hall_id=$_REQUEST["wedding_hall_id"];
	switch($value)
	{
		case 'r': 
				$sql="select R.comment,R.created_date,M.username from ".DBPREFIX."restaurant_review R inner join ".DBPREFIX."members M on R.member_id =M.member_id where R.restaurant_id='$restaurant_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$review[]=array("comment"=>$rs["comment"],"created_date"=>$rs["created_date"],"username"=>$rs["username"]);
    }
	if($con->NumRow()==0)
	{
	$msg=displayMessage("no reviews written for this restaurant...!!");
	$smarty->assign('restaurant_count',0);
	}
	else
	{
	$smarty->assign('restaurant_count',$con->NumRow());
	}
	$sql="select restaurant_id ,restaurant_name from ".DBPREFIX."restaurant  where restaurant_id='$restaurant_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$restaurantname=$rs["restaurant_name"];
	$restaurant_id=$rs["restaurant_id"];
	}
	$smarty->assign('review',$review);
	$smarty->assign('msg',$msg);
	$smarty->assign('restaurantname',$restaurantname);
	$smarty->assign('restaurant_id',$restaurant_id);
	$smarty->display('main.reviews.tpl');
	break;
	
	case 'h':  
			$sql="select H.comment,H.created_date,M.username from ".DBPREFIX."hotel_review H inner join ".DBPREFIX."members M on H.member_id =M.member_id where H.hotel_id='$hotel_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$review[]=array("comment"=>$rs["comment"],"created_date"=>$rs["created_date"],"username"=>$rs["username"]);
    }
	if($con->NumRow()==0)
	{
	$msg=displayMessage("no reviews written for this hotel...!!");
	$smarty->assign('hotel_count',0);
	}
	else
	{
	$smarty->assign('hotel_count',$con->NumRow());
	}
	$sql="select hotel_id,hotel_name from ".DBPREFIX."hotel  where hotel_id='$hotel_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$hotelname=$rs["hotel_name"];
	$hotel_id=$rs["hotel_id"];
	}
	$smarty->assign('review',$review);
	$smarty->assign('msg',$msg);
	$smarty->assign('hotelname',$hotelname);
	$smarty->assign('hotel_id',$hotel_id);
	$smarty->display('main.reviews.tpl');
	break;
	
	case 'w': 
			$sql="select W.comment,W.created_date,M.username from ".DBPREFIX."wedding_hall_review W inner join ".DBPREFIX."members M on W.member_id =M.member_id where W.wedding_hall_id='$wedding_hall_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$review[]=array("comment"=>$rs["comment"],"created_date"=>$rs["created_date"],"username"=>$rs["username"]);
    }
	if($con->NumRow()==0)
	{
	$msg=displayMessage("no reviews written for this wedding hall...!!");
	$smarty->assign('wedding_hall_count',0);
	}
	else
	{
	$smarty->assign('wedding_hall_count',$con->NumRow());
	}
	$sql="select wedding_hall_id ,wedding_hall_name from ".DBPREFIX."wedding_hall  where wedding_hall_id='$wedding_hall_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$wedding_hallname=$rs["wedding_hall_name"];
	$wedding_hall_id=$rs["wedding_hall_id"];
	}
	$smarty->assign('review',$review);
	$smarty->assign('msg',$msg);
	$smarty->assign('wedding_hallname',$wedding_hallname);
	$smarty->assign('wedding_hall_id',$wedding_hall_id);
	$smarty->display('main.reviews.tpl');
	break;
	}	
}
/*-------------------------------------------------------------------------------
|| Name: getReviewNumbers											            ||
|| Purpose: to get corresponding review number for restaurant					||
|| Source: custom																||
|| Modified: 08/01/2009															||
--------------------------------------------------------------------------------*/
function getReviewNumbers($restaurant_id)
{   
	$con=new dbcon;
	$sql="select count(restaurant_id) as review_count from ".DBPREFIX."restaurant_review where restaurant_id='$restaurant_id'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$review_count=$rs["review_count"];
	}										
	return $review_count;
}
/*-------------------------------------------------------------------------------
|| Name: google map											                    ||
|| Purpose: to get corresponding google map  									||
|| Source: custom																||
|| Modified: 09/01/2009															||
--------------------------------------------------------------------------------*/
function googlemap()
{ 
 $smarty = new Smarty_RoomsMenus(); 
 $restaurant_id=$_REQUEST["restaurant_id"];
 $hotel_id=$_REQUEST["hotel_id"];
 $smarty->display('main.googlemap.tpl');
	
}
/*-------------------------------------------------------------------------------
|| Name: getRightNavWeddinghall													||
|| Purpose: to get rightnav	for wedding hall									||
|| Source: custom																||
|| Modified: 14/01/2009															||
--------------------------------------------------------------------------------*/
function getRightNavWeddinghall()
{
 	$rightNavArr=array();
	
	$con=new dbcon;
	$sql="select wedding_hall_id,wedding_hall_name from ".DBPREFIX."wedding_hall order By created_date desc limit 0,10";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rightNavArr[$rs["wedding_hall_id"]]=$rs["wedding_hall_name"];
	}	
	return $rightNavArr;
}
/*-------------------------------------------------------------------------------
|| Name: getLeftNavWeddinghall													||
|| Purpose: to get leftnav option for wedding hall								||
|| Source: custom																||
|| Modified: 13/10/2008	, 20/10/2008											||
--------------------------------------------------------------------------------*/
function getLeftNavWeddinghall($value)
{
	$con=new dbcon;
	switch($value)
	{
		case '0':				
		$sql="select count(wedding_hall_id) as wedding_hall from ".DBPREFIX."wedding_hall";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["wedding_hall"];
		}									
		break;
	
		case '1':
		$sql="select wedding_hall_id, wedding_hall_name, (
SELECT avg(rating) FROM ".DBPREFIX."wedding_hall_rating where wedding_hall_id=R.wedding_hall_id group by wedding_hall_id) avg_rating from ".DBPREFIX."wedding_hall R order by  avg_rating desc limit 0,5";
		$con->Query($sql);	
		$count=$con->NumRow();						
		break;	
						
	}	
	return $count;
}
/*-------------------------------------------------------------------------------
|| Name: getmainpageReview											            ||
|| Purpose: to get main page review 									        ||
|| Source: custom																||
|| Modified: 08/01/2009															||
--------------------------------------------------------------------------------*/
function getmainpageReview()
{  

	$restaurant_id=rand(1,5);
	$con=new dbcon;
	$sql="select RR.comment,R.restaurant_name,R.restaurant_id,P.photo_name from (".DBPREFIX."restaurant_review RR inner join ".DBPREFIX."restaurant R  on RR.restaurant_id=R.restaurant_id) inner join ".DBPREFIX."restaurant_photo P on P.restaurant_id=R.restaurant_id where R.restaurant_id=$restaurant_id";
	
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
	$review_main_page[]=array("comment"=>$rs["comment"],"restaurant_name"=>$rs["restaurant_name"],"restaurant_id"=>$rs["restaurant_id"],"photo_name"=>$rs["photo_name"]);
	}										
	return $review_main_page;
}
/*-------------------------------------------------------------------------------
|| Name: getFacilityArrforhotel											            ||
|| Purpose: to get hotel facility						 					    ||
|| Source: custom																||
|| Modified: 05/02/2009																||
--------------------------------------------------------------------------------*/
function getFacilityArrforhotel()
{
	$facilityArr=array();
	$con=new dbcon;
	$sql="select facility_id ,facility_title  from ".DBPREFIX."hotel_facilities";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$facilityArr[$rs["facility_id"]]=$rs["facility_title"];
	}
	return $facilityArr;
}

/*-------------------------------------------------------------------------------
|| Name: getHotelNameArr													||
|| Purpose: to get Restaurant Name 							 					||
|| Source: custom																||
|| Modified: 05/02/2009																||
--------------------------------------------------------------------------------*/
function getHotelNameArr()
{
	$HotelNameArr=array();
	$con=new dbcon;
	$sql="select hotel_id,hotel_name from ".DBPREFIX."hotel";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$HotelNameArr[$rs["hotel_id"]]=$rs["hotel_name"];
	}
	return $HotelNameArr;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelAddressArr												        ||
|| Purpose: to get Restaurant Address 						 					||
|| Source: custom																||
|| Modified: 06/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelAddressArr($hotel_id)
{
	$HotelAddressArr=array();
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."hotel_address where hotel_id='$hotel_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$HotelAddressArr=array("hotel_id"=>$rs["hotel_id"],"address"=>$rs["address"],"country_id"=>getCountryName($rs["country_id"]),"state_id"=>getStateName($rs["state_id"]),"city"=>$rs["city"],"zipcode"=>$rs["zipcode"],"phone"=>$rs["phone"]);
	}
	return $HotelAddressArr;
}
/*-------------------------------------------------------------------------------
|| Name: getPopularHotel													    ||
|| Purpose: to get popular hotel											||
|| Source: custom																||
|| Modified: 06/02/2009															||
--------------------------------------------------------------------------------*/
function getPopularHotel()
{
	$PopularHotelArr=array();
	$con=new dbcon;
	$sql="select hotel_id, hotel_name, (
SELECT avg(rating) FROM ".DBPREFIX."hotel_rating  where hotel_id=H.hotel_id group by hotel_id) avg_rating from ".DBPREFIX."hotel H order by  avg_rating desc limit 0,5";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$PopularHotelArr[]=array("hotel_id"=>$rs["hotel_id"],"hotel_name"=>$rs["hotel_name"]);
	}
	return $PopularHotelArr;
}
/*-------------------------------------------------------------------------------
|| Name: getLeftNavHotel												     	||
|| Purpose: to get leftnav option for wedding hall								||
|| Source: custom																||
|| Modified: 06/02/2009										                	||
--------------------------------------------------------------------------------*/
function getLeftNavHotel($value)
{
	$con=new dbcon;
	switch($value)
	{
		case '0':				
		$sql="select count(hotel_id) as hotel from ".DBPREFIX."hotel";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["hotel"];
		}									
		break;
	
		case '1':
		$sql="select hotel_id, hotel_name, (
SELECT avg(rating) FROM ".DBPREFIX."hotel_rating where hotel_id=H.hotel_id group by hotel_id) avg_rating from ".DBPREFIX."hotel H order by  avg_rating desc limit 0,5";
		$con->Query($sql);	
		$count=$con->NumRow();						
		break;	
						
	}	
	return $count;
}
/*-------------------------------------------------------------------------------
|| Name: getRightNavHotel												        ||
|| Purpose: to get rightnav	for wedding hall									||
|| Source: custom																||
|| Modified: 06/02/2009															||
--------------------------------------------------------------------------------*/
function getRightNavHotel()
{
 	$RightNavHotel=array();
	
	$con=new dbcon;
	$sql="select hotel_id,hotel_name from ".DBPREFIX."hotel order By created_date desc limit 0,10";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$RightNavHotel[$rs["hotel_id"]]=$rs["hotel_name"];
	}	
	return $RightNavHotel;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelReviewNumbers											        ||
|| Purpose: to get corresponding review number for hotel					    ||
|| Source: custom																||
|| Modified: 09/02/2009															||
--------------------------------------------------------------------------------*/
function gethotelReviewNumbers($hotel_id)
{   
	$con=new dbcon;
	$sql="select count(hotel_id) as review_count from ".DBPREFIX."hotel_review where hotel_id='$hotel_id'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$review_count=$rs["review_count"];
	}										
	return $review_count;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelmainpageReview											        ||
|| Purpose: to get main page review for hotels								    ||
|| Source: custom																||
|| Modified: 09/02/2009														    ||
--------------------------------------------------------------------------------*/
function gethotelmainpageReview()
{  

	$hotel_id=rand(7,10);
	$con=new dbcon;
	/*$sql="select HR.comment,HR.hotel_id,H.hotel_name from ".DBPREFIX."hotel_review HR inner join ".DBPREFIX."hotel H where HR.hotel_id=$hotel_id  and H.hotel_id=HR.hotel_id ";*/
	 $sql="select HR.comment,H.hotel_name,H.hotel_id,P.photo_url from (".DBPREFIX."hotel_review HR inner join ".DBPREFIX."hotel H  on HR.hotel_id=H.hotel_id) inner join ".DBPREFIX."hotel_photo P on P.hotel_id=H.hotel_id where H.hotel_id=$hotel_id";
	
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
	$review_main_page[]=array("comment"=>$rs["comment"],"hotel_name"=>$rs["hotel_name"],"hotel_id"=>$rs["hotel_id"],"photo_name"=>$rs["photo_url"]);
	}										
	return $review_main_page;
}
/*-------------------------------------------------------------------------------
|| Name: getRoomTypeArr													        ||
|| Purpose: to get Room types							 					    ||
|| Source: custom																||
|| Modified: 09/02/2009															||
--------------------------------------------------------------------------------*/
function getRoomTypeArr()
{
	$RoomTypeArr=array();
	$con=new dbcon;
	$sql="select hotel_room_type_id,room_type  from ".DBPREFIX."hotel_room_types ";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$RoomTypeArr[$rs["hotel_room_type_id"]]=$rs["room_type"];
	}
	return $RoomTypeArr;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelRoomTypeArr												    ||
|| Purpose: to get hotel room type Option 							 		    ||
|| Source: custom																||
|| Modified:09/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelRoomTypeArr($hotel_id)
{
	$HotelRoomTypeArr=array();
	$con=new dbcon;
	$sql="select hotel_room_type_id  from ".DBPREFIX."hotel_room_types_tran where hotel_id=$hotel_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$HotelRoomTypeArr[]=$rs["hotel_room_type_id"];
	}
	return $HotelRoomTypeArr;
}
/*-------------------------------------------------------------------------------
|| Name: getRoomType															||
|| Purpose: to get get RoomType									 				||
|| Source: custom																||
|| Modified: 09/02/20089														||
--------------------------------------------------------------------------------*/
function getRoomType($hotel_id)
{	
	$con=new dbcon;
	$sql="select hotel_room_type_id from ".DBPREFIX."hotel_room_types_tran where hotel_id =$hotel_id ";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$RoomType[]=getRoomName($rs["hotel_room_type_id"]);	
	}	
		return $RoomType;
}
/*-------------------------------------------------------------------------------
|| Name: getRoomName															||
|| Purpose: to get Cuisine Name													||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getRoomName($hotel_room_type_id)
{
	$cuisineName=array();
		$con=new dbcon;
		$sql="select hotel_room_type_id,room_type from ".DBPREFIX."hotel_room_types where hotel_room_type_id=$hotel_room_type_id";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
			$RoomName[]=$rs["room_type"];
		}			
	return $RoomName;
}
/*-------------------------------------------------------------------------------
|| Name: getroomtypeID												            ||
|| Purpose: to get corresponding room type ID									||
|| Source: custom																||
|| Modified: 10/02/2009															||
--------------------------------------------------------------------------------*/
function getroomtypeID($value)
{
	$con=new dbcon;
	$sql="select hotel_room_type_id  from ".DBPREFIX."hotel_room_types  where room_type  like '$value'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$hotel_room_type_id =$rs["hotel_room_type_id"];
	}										
	return $hotel_room_type_id;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelRating													        ||
|| Purpose: to get Reservation Name												||
|| Source: custom																||
|| Modified: 10/02/2009															||
--------------------------------------------------------------------------------*/
function gethotelRating($hotel_id,$member_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."hotel_rating where hotel_id=$hotel_id and member_id=$member_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelWebsite												        ||
|| Purpose: to get Hotel source url					 					        ||
|| Source: custom																||
|| Modified: 10/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelWebsite($hotel_id)
{
	$con=new dbcon;
	$sql="select source_url from ".DBPREFIX."hotel where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$HotelWebsite=$rs["source_url"];
	}
	return $HotelWebsite;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelSearchRating												    ||
|| Purpose: to get rating at main page											||
|| Source: custom																||
||  Modified: 10/02/2009														||
--------------------------------------------------------------------------------*/
function getHotelSearchRating($hotel_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."hotel_rating where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelPhoto														    ||
|| Purpose: to get hotel Photo Name					 					        ||
|| Source: custom																||
|| Modified: 10/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelPhoto($hotel_id)
{
	$con=new dbcon;
	$sql="select photo_url from ".DBPREFIX."hotel_photo where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$photo_url=$rs["photo_url"];
	}
	return $photo_url;
}
/*-------------------------------------------------------------------------------
|| Name: getRoomTypeNumbers											            ||
|| Purpose: to get corresponding room type number								||
|| Source: custom																||
|| Modified: 11/02/2009															||
--------------------------------------------------------------------------------*/
function getRoomTypeNumbers($value)
{
	$con=new dbcon;
	$sql="select count(*) as room_type_count from ".DBPREFIX."hotel_room_types_tran  where (hotel_room_type_id like '$value' or hotel_room_type_id like '$value,%' or hotel_room_type_id like '%,$value,%' or hotel_room_type_id like '%,$value')";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$cuisine_count=$rs["room_type_count"];
	}										
	return $cuisine_count;
}

/*-------------------------------------------------------------------------------
|| Name: getCountHotelPicture														||
|| Purpose: to get Count Picture												||
|| Source: custom																||
|| Modified: 07/10/2008															||
--------------------------------------------------------------------------------*/
function getCountHotelPicture($hotel_id)
{
	$con=new dbcon;
	$sql="select count(photo_name) as count_picture from ".DBPREFIX."hotel_photo where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$CountHotelPicture=$rs["count_picture"];
	}
	return $CountHotelPicture;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelFacilityArr													||
|| Purpose: to get total hotel Facility list							 		||
|| Source: custom																||
|| Modified: 09/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelFacilityArr()
{
	$HotelFacilityArr=array();
	$con=new dbcon;
	$sql="select hotel_facility_id ,facility_title from ".DBPREFIX."hotel_facilities";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$HotelFacilityArr[$rs["hotel_facility_id"]]=$rs["facility_title"];
	}
	return $HotelFacilityArr;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelFacilityCheckedArr												||
|| Purpose: to get hotel facility checked Option 							 	||
|| Source: custom																||
|| Modified:09/02/2009															||
--------------------------------------------------------------------------------*/
function getHotelFacilityCheckedArr($hotel_id)
{
	$HotelFacilityCheckedArr=array();
	$con=new dbcon;
	$sql="select hotel_facility_id  from ".DBPREFIX."hotel_facility_map  where hotel_id=$hotel_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$HotelFacilityCheckedArr[]=$rs["hotel_facility_id"];
	}
	return $HotelFacilityCheckedArr;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelFacility														||
|| Purpose: to get Respective hotel facilities									||
|| Source: custom																||
|| Modified: 09/02/20089														||
--------------------------------------------------------------------------------*/
function getHotelFacility($hotel_id)
{	
	$con=new dbcon;
	/*$sql="select hotel_facility_id from ".DBPREFIX."hotel_facility_map where hotel_id =$hotel_id ";*/
	$sql="select amenity_name from ".DBPREFIX."hotel_amenity where hotel_id =$hotel_id ";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{

		$RoomType=explode(",", $rs["amenity_name"]);	
	}	
		return $RoomType;
}
/*-------------------------------------------------------------------------------
|| Name: getFacilityName														||
|| Purpose: to get Cuisine Name													||
|| Source: custom																||
|| Modified: 04/10/2008															||
--------------------------------------------------------------------------------*/
function getFacilityName($hotel_facility_id)
{
	$cuisineName=array();
		$con=new dbcon;
		$sql="select hotel_facility_id,facility_title  from ".DBPREFIX."hotel_facilities  where hotel_facility_id=$hotel_facility_id";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
			$RoomName[]=$rs["facility_title"];
		}			
	return $RoomName;
}
/*-------------------------------------------------------------------------------
|| Name: getHotelName														||
|| Purpose: to get Restaurnt Name												||
|| Source: custom																||
|| Modified: 07/10/2008															||
--------------------------------------------------------------------------------*/
function getHotelName($hotel_id)
{
	$con=new dbcon;
	$sql="select hotel_name from ".DBPREFIX."hotel where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$HotelName=$rs["hotel_name"];
	}
	return $HotelName;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelPriceRange												        ||
|| Purpose: to get hotel Price Range					 					    ||
|| Source: custom																||
|| Modified: 19/02/2009														    ||
--------------------------------------------------------------------------------*/
function gethotelPriceRange($hotel_id)
{
	$con=new dbcon;
	$sql="select price_range_id from ".DBPREFIX."hotel_price_range  where hotel_id=$hotel_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$hotelPriceRange=gethotelPriceRangeName($rs["price_range_id"]);
	}
	return $hotelPriceRange;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelPriceRangeName													||
|| Purpose: to get hotel Type Name						 					    ||
|| Source: custom																||
|| Modified: 19/02/2009															||
--------------------------------------------------------------------------------*/
function gethotelPriceRangeName($price_range_id)
{
	$con=new dbcon;
	$sql="select price_range from ".DBPREFIX."price_range where price_range_id=$price_range_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$PriceRangeName=$rs["price_range"];
	}
	return $PriceRangeName;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallPhoto													||
|| Purpose: to get wedding_hall Photo Name					 					||
|| Source: custom																||
|| Modified: 26/02/2009														    ||
--------------------------------------------------------------------------------*/
function getwedding_hallPhoto($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select photo_name from ".DBPREFIX."wedding_hall_photo  where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$photo_name=$rs["photo_name"];
	}
	return $photo_name;
}
/*-------------------------------------------------------------------------------
|| Name: gethotelRating													        ||
|| Purpose: to get wedding_hall rating											||
|| Source: custom																||
|| Modified: 26/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallRating($wedding_hall_id,$member_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."wedding_hall_rating where wedding_hall_id=$wedding_hall_id and member_id=$member_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallSearchRating											||
|| Purpose: to get wedding_hall rating on search page							||
|| Source: custom																||
|| Modified: 26/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallSearchRating($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select rating from ".DBPREFIX."wedding_hall_rating where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$rating=$rs["rating"];
	}
	return $rating;
}
/*-------------------------------------------------------------------------------
|| Name: getWeddingHallReviewNumbers											||
|| Purpose: to get corresponding review number for wedding hall					||
|| Source: custom																||
|| Modified: 26/02/2009															||
--------------------------------------------------------------------------------*/
function getWeddingHallReviewNumbers($wedding_hall_id)
{   
	$con=new dbcon;
	$sql="select count(wedding_hall_id) as review_count from ".DBPREFIX."wedding_hall_review where wedding_hall_id='$wedding_hall_id'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$review_count=$rs["review_count"];
	}										
	return $review_count;
}
/*-------------------------------------------------------------------------------
|| Name: getweddinghallmainpageReview											||
|| Purpose: to get main page review for wedding hall 							||
|| Source: custom																||
|| Modified: 08/01/2009															||
--------------------------------------------------------------------------------*/
function getweddinghallmainpageReview()
{  

	$wedding_hall_id=rand(1,5);
	$con=new dbcon;
	$sql="select RR.comment,R.wedding_hall_name,R.wedding_hall_id,P.photo_name from (".DBPREFIX."wedding_hall_review RR inner join ".DBPREFIX."wedding_hall R  on RR.wedding_hall_id=R.wedding_hall_id) inner join ".DBPREFIX."wedding_hall_photo P on P.wedding_hall_id=R.wedding_hall_id where R.wedding_hall_id=$wedding_hall_id";
	
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
	$review_main_page[]=array("comment"=>$rs["comment"],"wedding_hall_name"=>$rs["wedding_hall_name"],"wedding_hall_id"=>$rs["wedding_hall_id"],"photo_name"=>$rs["photo_name"]);
	}										
	return $review_main_page;
}
/*-------------------------------------------------------------------------------
|| Name: getGuestCapacityArr													||
|| Purpose: to get guest capacity							 					||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getGuestCapacityArr()
{
	$RoomTypeArr=array();
	$con=new dbcon;
	$sql="select guest_capacity_id,guest_capacity_range from ".DBPREFIX."guest_capacity ";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$RoomTypeArr[$rs["guest_capacity_id"]]=$rs["guest_capacity_range"];
	}
	return $RoomTypeArr;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallPriceRange											    ||
|| Purpose: to get wedding_hall Price Range					 					||
|| Source: custom																||
|| Modified: 27/02/2009														    ||
--------------------------------------------------------------------------------*/
function getwedding_hallPriceRange($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select price_range_id from ".DBPREFIX."wedding_hall_price_range  where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$wedding_hallPriceRange=gethotelPriceRangeName($rs["price_range_id"]);
	}
	return $wedding_hallPriceRange;
}
/*-------------------------------------------------------------------------------
|| Name: getservice															    ||
|| Purpose: to get get getservice									 			||
|| Source: custom																||
|| Modified: 27/02/2009														    ||
--------------------------------------------------------------------------------*/
function getservice($wedding_hall_id)
{	
	$con=new dbcon;
	$sql="select service_id from ".DBPREFIX."wedding_hall_service where wedding_hall_id =$wedding_hall_id ";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$servicetype[]=getServiceName($rs["service_id"]);	
	}	
		return $servicetype;
}
/*-------------------------------------------------------------------------------
|| Name: getServiceName															||
|| Purpose: to get service Name													||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getServiceName($service_id)
{
	$cuisineName=array();
		$con=new dbcon;
		$sql="select service_id,service_title from ".DBPREFIX."service  where service_id=$service_id";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
			$ServiceName[]=$rs["service_title"];
		}			
	return $ServiceName;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallWebsite												    ||
|| Purpose: to get wedding_hall source url					 				    ||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallWebsite($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select source_url from ".DBPREFIX."wedding_hall where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$wedding_hallWebsite=$rs["source_url"];
	}
	return $wedding_hallWebsite;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallcontactperson											||
|| Purpose: to get wedding_hall contact person name					 			||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallcontactperson($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select contact_person_name from ".DBPREFIX."wedding_hall where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$wedding_hallcontactperson=$rs["contact_person_name"];
	}
	return $wedding_hallcontactperson;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallcontactpersonphone										||
|| Purpose: to get wedding_hall contact person phone					 		||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallcontactpersonphone($wedding_hall_id)
{
	$con=new dbcon;
	$sql="select contact_person_phone from ".DBPREFIX."wedding_hall where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$wedding_hallcontactpersonphone=$rs["contact_person_phone"];
	}
	return $wedding_hallcontactpersonphone;
}
/*-------------------------------------------------------------------------------
|| Name: getallguestcapacitylist										        ||
|| Purpose: to get full guest capacity list   					 		        ||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/

	function getallguestcapacitylist()
	{
		$smarty = new Smarty_RoomsMenus();
		$getroomtypeArr=array();
		$con=new dbcon;	
		$sql="SELECT guest_capacity_range  FROM ".DBPREFIX."guest_capacity ";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
			$allguestcapacitylistArr[]=$rs["guest_capacity_range"];
		}
		
		$smarty->assign('getallguestcapacitylist',$allguestcapacitylistArr);
		$smarty->display('main.fullguestcapacitylist.tpl');
	}
/*-------------------------------------------------------------------------------
|| Name: getguestcapacityID												        ||
|| Purpose: to get corresponding guest capacity ID								||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getguestcapacityID($value)
{
	$con=new dbcon;
	$sql="select guest_capacity_id  from ".DBPREFIX."guest_capacity  where guest_capacity_range like '$value'";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$guest_capacity_id =$rs["guest_capacity_id"];
	}										
	return $guest_capacity_id;
}
/*-------------------------------------------------------------------------------
|| Name: getguestcapacityNumbers											    ||
|| Purpose: to get corresponding guest capacity number							||
|| Source: custom																||
|| Modified: 27/02/2009															||
--------------------------------------------------------------------------------*/
function getguestcapacityNumbers($value)
{
	$con=new dbcon;
	$sql="select count(*) as guest_capacity_count from ".DBPREFIX."wedding_hall_guest_capacity  where guest_capacity_id=$value";
	$con->Query($sql);	
	if($rs=$con->FetchRow())
	{
		$guest_capacity_count=$rs["guest_capacity_count"];
	}									
	return $guest_capacity_count;
	
}
/*-------------------------------------------------------------------------------
|| Name: getServiceCheckedArr												    ||
|| Purpose: to get service checked Option 							         	||
|| Source: custom																||
|| Modified:26/03/2009															||
--------------------------------------------------------------------------------*/
function getServiceCheckedArr($wedding_hall_id)
{
	$ServiceCheckedArr=array();
	$con=new dbcon;
	$sql="select service_id  from ".DBPREFIX."wedding_hall_service where wedding_hall_id=$wedding_hall_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$ServiceCheckedArr[]=$rs["service_id"];
	}
	return $ServiceCheckedArr;
}
/*-------------------------------------------------------------------------------
|| Name: getCountryid															||
|| Purpose: to get Country Name								 					||
|| Source: custom																||
|| Modified: 25/08/2008															||
--------------------------------------------------------------------------------*/
function getCountryid($country_title)
{
	$con=new dbcon;
	$sql="select country_id from ".DBPREFIX."country where country_title ='$country_title' ";
	$con->Query($sql);	
	if($rs=$con->FetchAssoc())
	{
		$country_id=$rs["country_id"];
	}
	return $country_id;
}
/*-------------------------------------------------------------------------------
|| Name: sendweddinghallmail											        ||
|| Purpose: to send mail to a wedding hall										||
|| Source: custom																||
|| Modified: 3/11/2008															||
--------------------------------------------------------------------------------*/
function sendweddinghallmail()
{
	$smarty = new Smarty_RoomsMenus();

	
		$name = $_REQUEST["first_name"];
		$address = $_REQUEST["address"];
		$address1 = $_REQUEST["address1"];
		$address2 = $_REQUEST["address2"];
		$phone = $_REQUEST["phone"];
		$zipcode = $_REQUEST["zipcode"];
		$country = $_REQUEST["country"];
		$Occasiondate = $_REQUEST["Occasiondate"];
		$aboutme = $_REQUEST["aboutme"];
		$myemail=$_REQUEST["e_mail"];
		$to=$_REQUEST["wedding_hall_email"];
		$wedding_hall_name=$_REQUEST["wedding_hall_name"];
		
		
		$subject = 'Enquiry from '.$name.' for '.$wedding_hall_name.' , Booking date'.$Occasiondate.''; 
		
		$message = ''.$aboutme.' My contact no. is '.$phone.' and my postal address is '.$address.'&nbsp;'.$country.'&nbsp;'.$zipcode.'';
		
		$headers = "From: " .$myemail. "\n";
		
		/*echo $to;
		echo $subject;
		echo $message;
		echo $headers;	
		die;*/
		$mail_sent = @mail( $to, $subject, $message, $headers );		
		$msg="Request Sent...!!";
		$smarty->assign('msg',$msg);
		
		header("location: $_SESSION[currenturl]&msg=$msg");
		die;
		
	
}
/*-------------------------------------------------------------------------------
|| Name: get Country Array	for weddinghall detail page							||
|| Purpose: to get Country Array											    ||
|| Source: custom																||
|| Modified: 27/04/2009															||
--------------------------------------------------------------------------------*/
function getCountryNameArr()
{
	$countryArr=array();
	
	$con=new dbcon;
	$sql="select country_id,country_title,code from ".DBPREFIX."country order by lower(country_title)";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
		$countryArr[$rs["country_title"]]=$rs["country_title"];
	}
	
	return $countryArr;
}
/*-------------------------------------------------------------------------------
|| Name: getwedding_hallAddressArr												        ||
|| Purpose: to get Restaurant Address 						 					||
|| Source: custom																||
|| Modified: 06/02/2009															||
--------------------------------------------------------------------------------*/
function getwedding_hallAddressArr($wedding_hall_id)
{
	$HotelAddressArr=array();
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."wedding_hall_address where wedding_hall_id='$wedding_hall_id'";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$wedding_hallAddressArr=array("wedding_hall_id"=>$rs["wedding_hall_id"],"address"=>$rs["address"],"country_id"=>getCountryName($rs["country_id"]),"state_id"=>getStateName($rs["state_id"]),"city"=>$rs["city"],"zipcode"=>$rs["zipcode"],"phone"=>$rs["phone"]);
	}
	return $wedding_hallAddressArr;
}
/*-------------------------------------------------------------------------------
|| Name: searchpopup_wedding_hall												||
|| Purpose: fethch country and state for wedding hall search pop up			 	||
|| Source: custom																||
|| Modified: 29/04/2009															||
--------------------------------------------------------------------------------*/
function searchpopup_wedding_hall()
{
	$smarty = new Smarty_RoomsMenus();
	$smarty->assign('countryArr',getCountryArr());
	$smarty->display('main.wedding_hall_search_popup.tpl');
}
/*-------------------------------------------------------------------------------
|| Name: searchpopup_hotel												        ||
|| Purpose: fethch country and state for hotel search pop up			 	    ||
|| Source: custom																||
|| Modified: 29/04/2009															||
--------------------------------------------------------------------------------*/
function searchpopup_hotel()
{
$smarty = new Smarty_RoomsMenus();
	$smarty->assign('countryArr',getCountryArr());
	$smarty->display('main.hotel_search_popup.tpl');
}
/*-------------------------------------------------------------------------------
|| Name: searchpopup_restaurant												    ||
|| Purpose: fethch country and state for hotel search pop up			 	    ||
|| Source: custom																||
|| Modified: 29/04/2009															||
--------------------------------------------------------------------------------*/
function searchpopup_restaurant()
{
$smarty = new Smarty_RoomsMenus();
	$smarty->assign('countryArr',getCountryArr());
	$smarty->display('main.restaurant_search_popup.tpl');
}
/*-------------------------------------------------------------------------------
|| Name: getRestaurantHours												        ||
|| Purpose: to get Restaurant Meal Served Option 						 		||
|| Source: custom																||
|| Modified: 03/09/2008															||
--------------------------------------------------------------------------------*/
function  getRestaurantHours($restaurant_id)
{
	$RestaurantHours=array();
	$con=new dbcon;
	$sql="select day,date_format(from_time,'%H:%i') as fromtime,date_format(to_time,'%H:%i') as totime from ".DBPREFIX."restaurant_hours where restaurant_id=$restaurant_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$RestaurantHours[]=array("day"=>$rs["day"],"from_time"=>$rs["fromtime"],"to_time"=>$rs["totime"]);
	}
	return $RestaurantHours;
}
/*-------------------------------------------------------------------------------
|| Name: getmainpagetravelvideo												    ||
|| Purpose: to get travel videos on main page of TRAVEL VIDEO  					||
|| Source: custom																||
|| Modified: 08/05/2009														    ||
--------------------------------------------------------------------------------*/
function  getmainpagetravelvideo()
{	
		$con=new dbcon;
		/*$sql="select filename,title,video_id from ".DBPREFIX."travel_video order by video_id desc";*/
		$sql="select filename,title,video_id,photo_name from ".DBPREFIX."travel_video where approved='Y' order by video_id desc";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
		{
		    $travelvideo[]=array("filename"=>$rs["filename"],"title"=>$rs["title"],"video_id"=>$rs["video_id"],"photo_name"=>$rs["photo_name"]);			
		}
		return $travelvideo;
}
/*-------------------------------------------------------------------------------
|| Name: myvideos															    ||
|| Purpose: To show members uploaded videos 									||
|| Source: custom																||
|| Modified: 22/09/2008															||
--------------------------------------------------------------------------------*/	
	function myvideos()
	{
		$smarty = new Smarty_RoomsMenus();
		$con=new dbcon;
		/*$sql="select filename,title,video_id from ".DBPREFIX."travel_video where member_id=$_SESSION[USER_MEMBER_ID] order by video_id";	*/
		$sql="select filename,title,video_id,photo_name from ".DBPREFIX."travel_video where member_id=$_SESSION[USER_MEMBER_ID] and approved='Y' order by video_id";
		$con->Query($sql);	
		while($rs=$con->FetchRow())
	{
		$mytravelvideo[]=array("filename"=>$rs["filename"],"title"=>$rs["title"],"video_id"=>$rs["video_id"],"photo_name"=>$rs["photo_name"]);	
	}
		$smarty->assign('mytravelvideo',$mytravelvideo);
		$smarty->display('main.travel.video.tpl');
	}	
	
/*-------------------------------------------------------------------------------
|| Name: getLeftNavtravelvideo												     ||
|| Purpose: to get leftnav option for wedding hall								||
|| Source: custom																||
|| Modified: 06/02/2009										                	||
--------------------------------------------------------------------------------*/
function getLeftNavtravelvideo($value)
{
	$con=new dbcon;
	switch($value)
	{
		case '0':				
		$sql="select count(video_id) as video from ".DBPREFIX."travel_video where approved='Y'";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["video"];
		}									
		break;
		
		case '1':				
		$sql="select count(video_id) as video from ".DBPREFIX."travel_video where member_id=$_SESSION[USER_MEMBER_ID] and approved='Y'";
		$con->Query($sql);	
		if($rs=$con->FetchRow())
		{
			$count=$rs["video"];
		}									
		break;
	
	}	
	return $count;
}	
/*-------------------------------------------------------------------------------
|| Name: videocomment											                ||
|| Purpose: to post review										                ||
|| Source: custom																||
|| Modified: 07/01/2009														    ||
--------------------------------------------------------------------------------*/
function videocomment()
{	
	$smarty = new Smarty_RoomsMenus();	
	$video_id=$_REQUEST["video_id"];
	
	if($_REQUEST["task"]=="send" && $_REQUEST["video_id"]!='')
	{
	
	$member_id=$_SESSION["USER_MEMBER_ID"];
	$comment=html_entities($_POST["comment"]);
	$con=new dbcon;
	$sql="select * from ".DBPREFIX."travel_video_comment where member_id=$member_id and 						video_id=$video_id";
	$con->Query($sql);
		if($con->NumRow()>0)
		{
		$sql="update ".DBPREFIX."travel_video_comment set video_id='$video_id',member_id='$member_id',comment='$comment',created_date=now() where member_id=$member_id and video_id=$video_id ";
		$con->Query($sql);
		}
		else
		{
		$sql="insert into ".DBPREFIX."travel_video_comment(video_id,member_id,comment,created_date) 		VALUES ('$video_id',$member_id,'$comment',now())";
		$con->Query($sql);
	}
	
	}	
	
		$smarty->assign('video_id',$video_id);
		header("location: inner.php?option=com_travel_video&task=openvideo&video_id={$video_id}");	
	/*	$smarty->display('main.travelvideo_detail.tpl');*/
	
}
/*-------------------------------------------------------------------------------
|| Name: getvideocomment										                ||
|| Purpose: to show reviews						                                ||
|| Source: custom																||
|| Modified: 08/01/2009	, 06/02/2009											|
--------------------------------------------------------------------------------*/
function getvideocomment($video_id)
{	
    $smarty = new Smarty_RoomsMenus();	
	$con=new dbcon;
	
	 $sql="select comment,created_date,member_id from ".DBPREFIX."travel_video_comment where video_id=$video_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
	$video_comment[]=array("comment"=>$rs["comment"],"created_date"=>$rs["created_date"],"member"=>getMembername($rs["member_id"]));
    }
	return $video_comment;
}
/*-------------------------------------------------------------------------------
|| Name: getRightNavtravelvideo													||
|| Purpose: to get rightnav	for wedding hall									||
|| Source: custom																||
|| Modified: 14/01/2009															||
--------------------------------------------------------------------------------*/
function getRightNavtravelvideo()
{
 	$rightNavArr=array();
	
	$con=new dbcon;
	$sql="select distinct city from ".DBPREFIX."travel_video order By city desc limit 0,5";
	$con->Query($sql);	
	while($rs=$con->FetchRow())
	{
	$rightNavArr[]=array("city"=>$rs["city"]);
	}	
	return $rightNavArr;
}
/*-------------------------------------------------------------------------------
|| Name: getMembername														    ||
|| Purpose: to get member type								 					||
|| Source: custom																||
|| Modified: 13/05/2009															||
--------------------------------------------------------------------------------*/
function getMembername($member_id)
{
	$member_name='';
	$con=new dbcon;
	$sql="select username from ".DBPREFIX."members where member_id=$member_id";
	$con->Query($sql);
	while($rs=$con->FetchRow())
	{
		$member_name=$rs["username"];
	}
	return $member_name;
}	
?>