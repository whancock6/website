<?php
	require "logged_in_check.php";
	require "set_session_vars_short.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RRC Google Doc Archiverator</title>
<link href="css/submitDocs.css" rel="stylesheet" type="text/css" />
<SCRIPT type="text/javascript">
	var whitespace = " \t\n\r";
	function isEmpty(s) {
	   var i;
	   if((s == null) || (s.length == 0))
	      return true;
	   // Search string looking for characters that are not whitespace
	   for (i = 0; i < s.length; i++) {   
	      var c = s.charAt(i);
	      if (whitespace.indexOf(c) == -1) 
	        return false;
	    }
	    // At this point all characters are whitespace.
	    return true;
	}
	function validate() {
	  if (isEmpty(document.form.name.value)) {
	        alert("Error: Document name is required.");
	        document.form.name.focus();
	        return false;
	    }
	  if (isEmpty(document.form.url.value)) {
	        alert("Error: URL is required.");
	        document.form.url.focus();
	        return false;
	    }
	  return true;		  
	}
</SCRIPT>
</head>

<body>
    <div id="wrapper">
    	<div id="container">
        	<header>
                <div id="headerIMG">
                    
                </div>
            </header>
            <form id="form" name="form" method="post" action="createDoc.php" onsubmit="return validate();">
			<h1>RRC Google Doc Archiverator</h1>
			<p><a href="points.php">Home</a> - <a href="docs.php">Docs</a> - <a href="submitDocs.php">Submit</a></p>
			<p>Store your RRC related google docs in our archives.</p>

			<label>Name
			<span class="small">Document Name, duh.</span>
			</label>
			<input type="text" name="name" id="name" />
			<div style="clear:both;"></div>
			<input type="hidden" name="user" value="<?php echo $firstName." ".$lastName; ?>"/>
			<label>Type
			<span class="small">Google Doc Type</span>
			</label>
			<select name="type">
					<option value="gDoc">Document</option>
					<option value="gForm">Form</option>
					<option value="gSpread">Spreadsheet</option>
					<option value="gPres">Presentation</option>
					<option value="gDraw">Drawing</option>
			</select>
			<div style="clear:both;"></div>
			<label>URL
			<span class="small">Google Doc Share URL</span>
			</label>
			<input type="text" name="url" id="url" />
			<div style="clear:both;"></div>
			<label>Description
			<span class="small">A sentence or two, please.</span>
			</label>
			<textarea name="description"></textarea>
			<div style="clear:both;"></div>
			<button type="submit">Submit</button>
			<div class="spacer"></div>

			</form>
         
        </div>
    </div>

<?php require "html_footer.txt"; ?>
