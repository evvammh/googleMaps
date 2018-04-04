<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>The Golf Pilot</title>
<link href="golf.css" rel="stylesheet" type="text/css" />
<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
<script type="text/javascript">
function vaildateForm()
	{
		flagRdoCourseRating=0;
		flagRdoAirportRating=0;
		for(i=1;i<=5;i++)
			{
				if(document.getElementById("rdoCourseRating"+i).checked==true)
				{
					flagRdoCourseRating=1;
				}
			}
		if(flagRdoCourseRating==0)
			{
				alert("please choose rating for Course");
				return false;
			}
		
		
		for(i=1;i<=5;i++)
			{
				if(document.getElementById("rdoAirportRating"+i).checked==true)
				{
					flagRdoAirportRating=1;
				}
			}
			if(flagRdoAirportRating==0)
				{
					alert("please choose rating for Airport.");
					return false;
				}
	}
</script>
</head>

<body>
<?php //include_once("before_save_submitreview.php");?>
    <form name="frmSubminReview" name="frmSubminReview" method="POST" action="save_submitreview.php" onsubmit="return vaildateForm();">
<table height="70">
</table>
<table align="center">
<tr>
    <td ><select name="slcCourseName" id="slcCourseName">
<option value="delhi course">Delhi course</option>
<option value="delhi course">Mumbai course</option>
<option value="delhi course">Koldata course</option>
</select></td>
<td class="linkview" width="300">How would you rate the course overall?</td>

<td width="40">
</td>
<td ><select name="slcAirportName" id="slcAirportName">
<option value="delhi airport">Delhi Airport</option>
<option value="a">Mumbai Airport</option>
<option vaue="a">Kolkata Airport</option>
</select></td>
<td class="linkview" width="300">HOW would you rate the airport overall?</td>

</tr>
<tr >
<td width="50">
</td>
<td class="linkview" align="right">
<input type="radio" name="rdoCourseRating" id="rdoCourseRating5" value="5" /> 5stars<br />
<input type="radio" name="rdoCourseRating" id="rdoCourseRating4" value="4"  /> 4stars<br/>
<input type="radio" name="rdoCourseRating" id="rdoCourseRating3" value="3"  /> 3stars<br />
<input type="radio" name="rdoCourseRating" id="rdoCourseRating2" value="2"  /> 2stars<br />
<input type="radio" name="rdoCourseRating" id="rdoCourseRating1" value="1" /> 1stars<br />
</td>
<td width="100">
</td>
<td width="50">
</td>

<td class="linkview">
<input type="radio" name="rdoAirportRating" id="rdoAirportRating5" value="5" /> 5stars<br />
<input type="radio" name="rdoAirportRating" id="rdoAirportRating4" value="4"  /> 4stars<br/>
<input type="radio" name="rdoAirportRating" id="rdoAirportRating3" value="3"  /> 3stars<br />
<input type="radio" name="rdoAirportRating" id="rdoAirportRating2" value="2"  /> 2stars<br />
<input type="radio" name="rdoAirportRating" id="rdoAirportRating1" value="1" /> 1stars<br />
</td>

</tr>
</table>

<br>
</br>
<table  align="center" >
<tr>
<td>
    <textarea name="txtCourseComment" id="txtCourseComment" COLS=50 ROWS=6>
Tell us about your experience on the course. 
</textarea>
</td>
<td width="80">
</td>
<td>
    <textarea class="linkview" name="txtAirportComment" id="txtAirportComment" COLS=50 ROWS=6>
Tell us about your experience with the airport. 
</textarea>
</td>
</tr>
<tr align="center">
<td width="40" height="30">
</td>
<br/>
<td>
 <input type='submit' name='Submit' value='Submit' />
</td>
</tr>
</table>
</body>
</html>
