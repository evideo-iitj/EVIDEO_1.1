<?php 
$mediaid=$_GET['media_id'];
$id=$_GET['id'];
$title=$_GET['title'];
//$url=$_GET['url'];
$description=$_GET['description'];
$start=$_GET['start'];
$stop=$_GET['stop'];
$con = mysql_connect("localhost","root","123");

$type = "bookmarks";

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }

mysql_select_db("matterhorn", $con);

$query = " SELECT * FROM bookmarks WHERE id = $id and media_id = '$mediaid'";

$result = mysql_query($query);

$info = mysql_fetch_array($result);

$old_mediaid = $info['media_id'];
$old_start = $info['start'];

exec(" python /var/www/frames/delFrames.py $old_mediaid $old_start $type ");

if(mysql_query("UPDATE bookmarks SET `start`='$start',`stop`='$stop',`title` = '$title',`description`='$description' WHERE id='$id' and media_id='$mediaid'")){

	echo "Success";
        exec("python /var/www/frames/exFrames.py $id $start $type");

}
?> 