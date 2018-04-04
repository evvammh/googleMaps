<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<title>Forgot password</title>
<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
<link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
<script src="scripts/pwdwidget.js" type="text/javascript"></script>      
<link href="golf.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function echeck(str) {

		var at="@"
		var dot="."
		var lat=str.indexOf(at)
		var lstr=str.length
		var ldot=str.indexOf(dot)
		if (str.indexOf(at)==-1){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
		   alert("Invalid E-mail ID")
		   return false
		}

		if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
		    alert("Invalid E-mail ID")
		    return false
		}

		 if (str.indexOf(at,(lat+1))!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
		    alert("Invalid E-mail ID")
		    return false
		 }

		 if (str.indexOf(dot,(lat+2))==-1){
		    alert("Invalid E-mail ID")
		    return false
		 }
		
		 if (str.indexOf(" ")!=-1){
		    alert("Invalid E-mail ID")
		    return false
		 }

 		 return true					
	}
        function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}
function validateForm(){
    if(trim(document.frmForgotPassword.txtEmailAddress.value)=="")
	{
		alert("Please Specify Your Email ID");
		document.frmForgotPassword.txtEmailAddress.focus();
		return false;
	}
        
        emailID=document.frmForgotPassword.txtEmailAddress;
	if (echeck(emailID.value)==false)
	{
		emailID.value="";
		emailID.focus();
		return false;
	}	
}
</script>
</head>

<div id='fg_membersite'>
    <body  style="margin-left:30px ;" >
        <form name="frmForgotPassword" id="frmForgotPassword" action="send_forgotpassword.php" method="POST" onsubmit="return validateForm();">
            <div class='container'>
                <label for='name' ><?php echo $_REQUEST["msg"];?> </label></div>
            <div class='container'>
                <label for='name' >Please Provide You Email Address: </label><br/>
                <input type='text' name='txtEmailAddress' id='txtEmailAddress'  maxlength="50" /><br/>
                <span id='register_name_errorloc' class='error'></span>
            </div>
            <div class='container'>

                <input type='submit' name='register'  class="groovybutton" style="width: 290px;" value="Send Me link to reset password " />

            </div>
        </form>
    </body>
