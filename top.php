<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>The Golf Pilot</title>
        
        <link rel="STYLESHEET" type="text/css" href="style/fg_membersite.css" />
        <link href="style.css" rel="stylesheet" type="text/css" />
        <script type='text/javascript' src='scripts/jquery.js'></script>
        <script type='text/javascript' src='scripts/gen_validatorv31.js'></script>

        <link rel="STYLESHEET" type="text/css" href="style/pwdwidget.css" />
        <link href="golf.css" rel="stylesheet" type="text/css" />
        <link href="style/login-box.css" rel="stylesheet" type="text/css" />
        <script src="scripts/pwdwidget.js" type="text/javascript"></script> 
		<link href="golf-website.css" rel="stylesheet" type="text/css" />
    </head>
    <?PHP ?> 
    <body style=" margin-top:5px;margin-left:120px ;">
        <TABLE border="0" width="100%">
            <TR>
                <TD>
                    <!-- Header Starts here-->
                    <table class="deepsea">
                        <div id="border" class="main_frame" >

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <a href="http://www.facebook.com" target="_blank"><img src="images/facebook5.png" alt="facebook" title="Facebook" height="80" width="100" border="0" style="vertical-align:middle;border:0"/></a>
                            <a href="http://www.twitter.com"  target="_blank"><img src="images/Twitter.png" alt="Twitter" title="Twitter" height="80" width="100" border="0" style="vertical-align:middle;border:0"/></a>
                            <ul id="menu">
                                <li ><a href="index.php?page=custommap" class="home"> <span></span></a></li>
                                <li><a href="index.php?page=aboutgolfpilot" class="about"><span></span></a></li>
                                <li><a href="index.php?page=submit_new_course" class="courses"><span></span></a></li>
                                <li><a href="index.php" class="contact"><span></span></a></li>
                                <li><a href="index.php?page=register" class="register"><span></span></a></li>
                                <li><a href="index.php?page=submitreview" class="reviews"><span></span></a></li>
                                <li><a href="index.php?page=golfreview" class="userforum"><span></span></a></li>


                            </ul>
                        </div>

                    </table>
                    <!-- Header Ends here-->
                </TD>
            </TR>
            <TR>
                <TD>
                    <div align="right">
                        <?
                        if ($_SESSION["IS_USER_LOGGED_IN"]) {
                            echo"Welcome " . $_SESSION["USERNAME"] . '&nbsp;&nbsp;<a href="index.php?page=logout&task=logout" title="Logout" onClick="return confirm(\'Are you sure you want to Logout?\');">Log Out</a>';
                        }
                        ?>
                    </div>
                    <!-- Contents Starts here-->

