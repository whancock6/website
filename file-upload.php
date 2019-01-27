<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd"> 

<html lang="en"> 
    <head> 
        <meta http-equiv="content-type" content="text/html; charset=iso-8859-1"> 
     
        <link rel="stylesheet" type="text/css" href="stylesheet.css"> 
         
        <title>Upload form</title> 
     
    </head> 
     
    <body> 
     
    <form id="Upload" action="upload.processer.php" enctype="multipart/form-data" method="post"> 
     
        <h1> 
            Upload form 
        </h1> 
         
        <p> 
            <label for="file">File to upload:</label> 
            <input id="file" type="file" name="file"> 
        </p> 
                 
        <p> 
            <label for="submit">Press to...</label> 
            <input id="submit" type="submit" name="submit" value="Upload me!"> 
        </p> 
     
    </form> 
     
     
    </body> 

</html>