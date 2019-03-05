<?php
	require "logged_in_check.php";
	require "database_connect.php";
	
	$query = $db->query("SELECT * FROM Docs ORDER BY Docs.date DESC");
		$query->setFetchMode(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>RRC Google Doc Archive</title>
<link href="css/submitDocs.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <div id="wrapper">
    	<div id="container">
        	<header>
                <div id="headerIMG">
                    
                </div>
            </header>
            <h1>RRC Google Doc Archive v1.0</h1>
			<p><a href="points.php">Home</a> - <a href="docs.php">Docs</a> - <a href="submitDoc.php">Submit</a></p>
			<p>A glorious archive of a lot of different google docs.</p>
			
			<div id="docsList">
            	<table>
                	<tr class="">
                    	<td colspan="4" class="recentDocsHdr weightBold">Recent Documents</td>
                    </tr>
                	<tr class="weightBold">
                    	<td class="docsIcon"></td>
                        <td class="docsName">Document</td>
                        <td>User</td>
                        <td>Date</td>
                    </tr>
					<?php
						while($row = $query->fetch()){
							$name = $row[Name];
							$url = $row[URL];
							$sql_date = $row[Date];
							$date = date("m/d/Y",strtotime($sql_date));
							$user = $row[User];
							$type = $row[Type];
							echo "<tr class=\"docsListRows\">";
							echo "<td class=\"".$type." docsIcon\"></td>";
							echo "<td class=\"docsListRows docsName\"><a href=\"".$url."\">".$name."</a></td>";
							echo "<td>".$user."</td>";
							echo "<td>".$date."</td>";
							echo "</tr>";
						}
					?>
                </table>
<br/><br/><br/><br/><br/><br/>
            </div>
        </div>
    </div>

<?php require "html_footer.txt"; ?>