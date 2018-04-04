<?PHP
include_once("config.php");
include_once("$ABSPATH/include/functions.php");
include_once("$ABSPATH/classes/forgotpassword.class.php");
$objForgotpassword = new Forgotpassword();

if (isset($_GET['code'])) {
    $objResult = $objForgotpassword->confirmResetPassword($_GET["code"]);
    if ($objResult->result) {
        $result = true;
    } else {
        $result = false;
    }
}
?>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'/>
<title>Reset Password</title>
<link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
<script type='text/javascript' src='scripts/gen_validatorv31.js'></script>
<link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
<script src="scripts/pwdwidget.js" type="text/javascript"></script>      
<link href="golf.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    
    function trim(stringToTrim) {
        return stringToTrim.replace(/^\s+|\s+$/g,"");
    }
    function validateForm(){
        if(trim(document.frmResetPassword.txtPassword.value)=="")
        {
            alert("Please Enter your new Password !!");
            document.frmResetPassword.txtPassword.focus();
            return false;
        }
        var pass=trim(document.frmResetPassword.txtPassword.value);
        if(pass.length<6){
            alert("Password must be atleast 6 characters long !!");
            document.frmResetPassword.txtPassword.focus();
            return false;
        }
        if(trim(document.frmResetPassword.txtRePassword.value)=="")
        {
            alert("Please Retype your Password !!");
            document.frmResetPassword.txtRePassword.focus();
            return false;
        }
        var repass=trim(document.frmResetPassword.txtRePassword.value);
        if(repass.length<6){
            alert("Password must be atleast 6 characters long !!");
            document.frmResetPassword.txtRePassword.focus();
            return false;
        }
        
        if(trim(document.frmResetPassword.txtPassword.value)!=trim(document.frmResetPassword.txtRePassword.value)){
            alert("Password Donot Match !!")
            return false;
        }	
    }
</script>
</head>
<? if ($result) { ?>
    <div id='fg_membersite'>
        <body  style="margin-left:30px ;" >
            <form name="frmResetPassword" id="frmResetPassword" action="send_forgotpassword.php?task=save_password" method="POST" onsubmit="return validateForm();">

                <div class='container'>
                    <label for='password' >Enter new password: </label><br/>
                    <input type='password' name='txtPassword' id='txtPassword'  maxlength="50" /><br/>
                </div>
                <div class='container'>
                    <label for='repassword' >Repeat password: </label><br/>
                    <input type='password' name='txtRePassword' id='txtRePassword'  maxlength="50" /><br/>
                </div>
                <input type="hidden" name="email" id="email" value="<?php echo $objResult->msg; ?>"/>
                <div class='container'>
                    <input type='submit' name='register' class="groovybutton" value="Submit" />
                </div>
            </form>
        </body>
    <? } else { ?>
        <body>

            <div id='fg_membersite'>            <div class='container'>
                    <label for='name' ><font color='red'><?php echo $objResult->msg; ?> </font></label></div>
            </div>
        </body>
    <? } ?>
