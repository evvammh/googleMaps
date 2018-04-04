<?php /* require the user as the parameter */
if(isset($_GET['key']) && $_GET['key']=="golfpilot123") {

  /* soak in the passed variable or set our own */
  $number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10; //10 is the default
  $format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml'; //xml is the default
 // $user_id = intval($_GET['user']); //no default

  /* connect to the db */
  $link = mysql_connect('localhost','root','') or die('Cannot connect to the DB');
  mysql_select_db('testdb',$link) or die('Cannot select the DB');

  /* grab the posts from the db */
  //$query = "SELECT post_title, guid FROM wp_posts WHERE post_author = $user_id AND post_status = 'publish' ORDER BY ID DESC LIMIT $number_of_posts";
 $pwdmd5 = md5(mysql_real_escape_string(trim($_GET['password'])));
 $username= mysql_real_escape_string(trim($_GET['username']));
        $query = "Select * from fgusers where username='$username' and password='$pwdmd5' and confirmcode='y'";
  $result = mysql_query($query,$link) or die('Errant query:  '.$query);

  /* create one master array of the records */
  $posts = array();
  $result_counter=0;
  if(mysql_num_rows($result)) {
    while($user = mysql_fetch_assoc($result)) {
      $users[] = array('user'=>$user);
	  $result_counter++;
    }
  }
if($result_counter==0)
{
$user["result"]="Username password are invalid.";
$users[] = array('user'=>$user);
}
  /* output in necessary format */
  if($format == 'json') {
    header('Content-type: application/json');
    echo json_encode(array('users'=>$users));
  }
  else {
    header('Content-type: text/xml');
    echo '<users>';
    foreach($users as $index => $user) {
      if(is_array($user)) {
        foreach($user as $key => $value) {
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
    echo '</users>';
  }

  /* disconnect from the db */
  @mysql_close($link);
}
else
{
echo"Key is not valid";
}
?>