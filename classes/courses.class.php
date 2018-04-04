<?php

class Courses extends dbcon {

    public function __construct() {

        parent::__construct();
    }

    public function saveCourse() {
        try {
            $this->course_name = add_quote($_POST["course_name"]);
            $this->email = add_quote($_POST["email"]);
            $this->street = add_quote($_POST["street"]);
            $this->city = add_quote($_POST["city"]);
            $this->state = add_quote($_POST["state"]);
            $this->country = add_quote($_POST["country"]);
            $this->zip_code = add_quote($_POST["zip_code"]);
            $this->course_phone_no = add_quote($_POST["course_phone_no"]);
            $this->course_website = add_quote($_POST["course_website"]);
            $this->airport = add_quote($_POST["airport"]);
            $this->distance_from_airport = add_quote($_POST["distance_from_airport"]);
            $this->comment = $_POST["comment"];

            //$sql = "insert into " . DBPREFIX . "courses(course_name,email,street,city,state,country,zip_code,course_phone_no,course_website,airport,distance_from_airport,comment,created_date) values ('$this->course_name','$this->email','$this->street','$this->city','$this->state','$this->country','$this->zip_code','$this->course_phone_no','$this->course_website','$this->airport','$this->distance_from_airport','$this->comment',now() )";
            //$this->Query($sql);
            //$this->id = $this->InsertId();
            
            $this->sendCourseSubmitionMail();
        } catch (Exception $e) {
            return "Error in saveMemberUser - " . $e->getMessage();
        }
    }

    public function sendCourseSubmitionMail() {
        try {
            $msg='<div class=\'container\'>
	 <label >
    Thank you !!<br>
Course information saved successfully.<br/>
You entered following information.<br/><br/>
    <font style="font-size: 10px;"><strong>
    </font></label>
	<label for="awf_field-16203993">Course Name: </label>
    <span class=\'container\'>'.$this->course_name .'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203994">Email: </label>
    <span class=\'container\'> '.$this->email.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203995street1">Street:</label>
    <span class=\'container\'>'.$this->street.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203995city">City:</label>
    <span class=\'container\'>'.$this->city.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203995state">Course State or Province:</label>
    <span class="af-selectWrap">'.$this->state.'</span>
        <div class=\'container\'><label for="awf_field-16203995state">Course Country:</label>
    <span class="af-selectWrap">'.$this->country.'</span>
	
	<div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203995zip">ZIP Code:</label>
    <span class=\'container\'>'.$this->zip_code.'</span>
    </div>
    <div class=\'container\'><label for="awf_field-16203996">Course Phone Number:</label>
    <span class=\'container\'>'.$this->course_phone_no.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203997">Course Website:</label>
    <span class=\'container\'>'.$this->course_website.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203998">Airport:</label>
    <span class=\'container\'>'.$this->airport.'</span>
    <div class="af-clear"></div>
    </div>
    <div class=\'container\'><label for="awf_field-16203999">Distance from Airport to Course (miles):</label>
    <span class=\'container\'>'.$this->distance_from_airport.'</span>
    <label>
    <font style="font-size: 10px;"><strong>
    </font></label>
    <span class=\'container\'>'.$this->comment.'</span>
    <div class="af-clear"></div>
    </div>
    <div class="af-element buttonContainer"></div>
    </div>
    </div>
    </div>
    <div class="af-footer" id="af-footer-1113534864">
    <div class="bodyText">
    <p>&nbsp;</p>
    </div>
    </div>
    Regards,<br/>
    The GolfPilot Team.
  ';
            $email="sameer.aswal@gmail.com,manishjss06@gmail.com,".$this->email;
           SendMail($email, "New Course Saved", $msg);
        } catch (Exception $e) {
            return "Error in saveMemberUser - " . $e->getMessage();
        }
    }
}
?>