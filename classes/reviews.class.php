<?php 
class Reviews extends dbcon {

   

    /**
     * Admin Login DAO Constructor
     */
    public function __construct() {

        parent::__construct();
       
    }
	function saveReview(){
				try {
					$this->course_name = add_quote($_POST["slcCourseName"]);
					$this->airport_name = add_quote($_POST["slcAirportName"]);
					$this->course_over_all = add_quote($_POST["rdoCourseRating"]);
                                        $this->airport_over_all = add_quote($_POST["rdoAirportRating"]);
					$this->course_comment = add_quote($_POST["txtCourseComment"]);
					$this->airport_comment = add_quote($_POST["txtAirportComment"]);
					
					
					$sql = "insert into " . DBPREFIX . "user_reviews(course_over_all,airport_over_all,user_id,comment_for_course,comment_for_airport,course_name,airport_name) values ('$this->course_over_all','$this->airport_over_all','1','$this->course_comment','$this->airport_comment','$this->course_name','$this->airport_name' )";
					$this->Query($sql);
					$this->id = $this->InsertId();
                                        echo"Thanks for your comment.";
                                        //echo'<html><script type="text/javascript">alret("Thanks for your comments.");</script></html>';
					}
					 catch (Exception $e) {
					return "Error in saveReview - " . $e->getMessage();
				}

	}
}
?>
