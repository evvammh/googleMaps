<?php /* require the user as the parameter */
if(isset($_GET['user']) && intval($_GET['user'])) {

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default
  $user_id = intval($_GET['user']); //no default

  /* connect to the db */
  $link = mysql_connect('localhost','root','') or die('Cannot connect to the DB');
  mysql_select_db('testdb',$link) or die('Cannot select the DB');



  
 $pwdmd5 = md5(mysql_real_escape_string(trim($_GET['password'])));
 $email= mysql_real_escape_string(trim($_GET['email']));
        $query = "Select * from fgusers where email='$email' and password='$pwdmd5' and confirmcode='y'";

  $result = mysql_query($query,$link) or die('Errant query:  '.$query);
if(!$result || mysql_num_rows($result) <= 0)
        {
            /*$this->HandleError("Error logging in. The email or password does not match");
            return false;*/
			$post = array('result'=>'Invalid');
			$posts[] = array('post'=>$post);
        }
		else{
			$post = array('result'=>'Valid');
			$posts[] = array('post'=>$post);
			}
  /* create one master array of the records */
  //$posts = array();
  /*if(mysql_num_rows($result)) {
    while($post = mysql_fetch_assoc($result)) {
      $posts[] = array('post'=>$post);
    }
  }*/

  /* output in necessary format */
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('posts'=>$posts));
  }
  else {
    header('Content-type: text/xml');
    echo '<posts>';
    foreach($posts as $index => $post) {
      if(is_array($post)) {
        foreach($post as $key => $value) {
          echo '<',$key,'>';
          if(is_array($value)) {
            foreach($value as $tag => $val) {
              echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
            }
          }
          echo '</',$key,'>';
        }
      }
    }
    echo '</posts>';
  }

  /* disconnect from the db */
  @mysql_close($link);
}
?>