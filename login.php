<style>
    
</style>
<script type="text/javascript">

    function callNewAccount()
    {
        window.location="index.php?page=register";
    }

    function forgotpasssword()
    {
        window.open('forgotpassword.php','','width=500,height=200,top=243,left=200');

    }
</script>
<!-- Form Code Start -->

<div background="images/grass.jpg">
    <!-- Form Code Start -->
    <div id=''>
        <?php
        if ($_SESSION["IS_USER_LOGGED_IN"]) {
            ?> 
            <div style="margin-bottom: 30px;">
                        <div class="searchbox">
                           <input name="textfield" type="text" class="searchinputbox" id="textfield" value="<?=$_SESSION["USERNAME"]?>"/>
                    </div>
                        <div style="float: left;">
                       <a href="index.php?page=logout&task=logout" title="Logout" onClick="return confirm('Are you sure you want to Logout?');"> <img src="./images/button_logout.png"   alt="" border="0"/></a>
                        </div>
                    </div>
            <?
    } else {
            ?>

            <form id='login' action='<?php echo $fgmembersite->GetSelfScript(); ?>' method='post' accept-charset='UTF-8'>
              
                    

                    <input type='hidden' name='submitted' id='submitted' value='1'/>

                    <div class='short_explanation'>* required fields</div>
                    <div><span style="color: red;" class='error'><?php echo $fgmembersite->GetErrorMessage(); ?></span></div>
                    <label for='username' >
                        <?php
                        if ($_SESSION["IS_USER_LOGGED_IN"]) {
                            echo" Welcome" . " " . $_SESSION["USERNAME"];
                        }
                        ?>
                    </label><br/>
                    <!--                        <div class='container'>
                                               
                                                <label for='username' >UserName*:</label><br/>
                                                <input type='text' name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" /><br/>
                                                <span id='login_username_errorloc' class='error'></span>
                                            </div>
                                            <div class='container'>
                                                <label for='password' >Password*:</label><br/>
                                                <input type='password' name='password' id='password' maxlength="50" /><br/>
                                                <span id='login_password_errorloc' class='error'></span>
                                            </div>-->
                    

                    
                    




                    <div id="login-box" >
                        <input type="image" src="./images/loginbox_2_2.png" style="margin-top:-65px; margin-left:-20px;"  alt="" >&nbsp;&nbsp;
                        <img src="./images/loginbox_2_3.png"  style="margin-top:-65px; margin-left:-25px; font-size-adjust: 46" alt="" onClick="callNewAccount();"/>
                        <br/>
                        <strong>
                            <label style="margin-right:325px; color: #A1A09f" >username</label>
                        </strong>

                        <input type="text" name='username' id='username' value='<?php echo $fgmembersite->SafeDisplay('username') ?>' maxlength="50" class="form-login" title="Username" size="30"  style=" height: 10px; width: 170px;margin-left:-25px;" />

                        <div><span style="color: red;" id='login_username_errorloc' class='error'></span></div>

                        <br/><strong><label style="margin-right:325px; color: #A1A09f" >password</label></strong><br/>
                        <input type="password" name='password' id='password' maxlength="50"class="form-login" title="Password" size="30"  style="height: 10px; width: 170px;margin-left:-25px;" /> 

                        <div><span style="color: red;" id='login_password_errorloc' class='error'></span></div>

                        <div><label style="margin-right:280px; color: #A1A09f" > <a href="javascript:forgotpasssword();void(0);" style="margin-left:-60px;">Forgot PW?</a></label></div>
                        <input type="image" name='submitLoginImg' src="./images/button_login.png"  style="margin-left:80px;"/><br/>
                        <img src="./images/button_createaccount.png"  style="margin-top:45px; margin-left:-60px;" alt="" onClick="callNewAccount();"/>
                    </div>
                    <input type="hidden" name="submitLogin" id="submitLogin" value="1"/>



    <!--                        <table>
                                <tr>
                                    <td class='pwdlink'>
                                        <label color="white">
                                            <a href="javascript:forgotpasssword()" style="display:block; font-size: 12pt; color:white " >Forgot Password?</a>
                                    </td>&nbsp;&nbsp;</label>
                                    <td>
                                        <div class='container'>
                                            <input type='submit' name='submitLogin' value='Login'   
                                                   class="groovybuttonSubmit" />

                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class='container'>
                                <input type='button' name='register'  
                                       class="groovybutton"  
                                       value="Create New Account" onClick="callNewAccount()"/>
                            </div>-->

                
            </form>


            <script type='text/javascript'>
                // <![CDATA[

                var frmvalidator  = new Validator("login");
                frmvalidator.EnableOnPageErrorDisplay();
                frmvalidator.EnableMsgsTogether();

                frmvalidator.addValidation("username","req","Please provide your username");
        
                frmvalidator.addValidation("password","req","Please provide the password");

    	
                // ]]>
            </script>

        </div>
    </div>

    <script type='text/javascript'>
        // <![CDATA[

        var frmvalidator  = new Validator("login");
        frmvalidator.EnableOnPageErrorDisplay();
        frmvalidator.EnableMsgsTogether();

        frmvalidator.addValidation("username","req","Please provide your username");
        
        frmvalidator.addValidation("password","req","Please provide the password");

    	
        // ]]>
    </script>
<?
}?>