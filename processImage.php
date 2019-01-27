<?php

  require "database_connect.php";

$allowedExts = array("gif", "jpeg", "jpg", "png");
$temp = explode(".", $_FILES["file"]["name"]);
$extension = end($temp);
$uid = uniqid();
if ((($_FILES["file"]["type"] == "image/gif")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/x-png")
|| ($_FILES["file"]["type"] == "image/png"))
&& ($_FILES["file"]["size"] < 20000000)
&& in_array($extension, $allowedExts))
  {
  
  if ($_FILES["file"]["error"] > 0)
    {
    //echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    }
  else
    {
    //   echo "Upload: " . $_FILES["file"]["name"] . "<br>";
    // echo "Type: " . $_FILES["file"]["type"] . "<br>";
    // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
    // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

    if (file_exists("files/" . $_FILES["file"]["name"]))
      {
      echo $_FILES["file"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"], "files/" .$uid. $_FILES["file"]["name"]);
      
      $path="files/".$uid. $_FILES["file"]["name"];
      $user=1;
      $year= $_GET['year'];
      $caption = $_POST['caption'];

      $insertImage= $db->prepare("INSERT INTO photos (img_path, year, caption, userId) VALUES (:img_path, :year, :caption, :userId)");
      $insertImage->bindValue("img_path",$path, PDO::PARAM_STR);
      $insertImage->bindValue("year",$year, PDO::PARAM_STR);
      $insertImage->bindValue("caption",$caption, PDO::PARAM_STR);
      $insertImage->bindValue("userId",$user, PDO::PARAM_STR);
      $insertImage->execute();


      //echo "Stored in: " . "files/" . $uid . $_FILES["file"]["name"];
      
      }
    }
  }
else
  {
  echo "Invalid file";
  }
  error_reporting(E_ALL | E_WARNING | E_NOTICE);
  ini_set('display_errors', TRUE);

  header( 'Location: history.php?year='.$year ) ;
  exit;
?>