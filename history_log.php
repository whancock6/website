<div class="sub-header"><span class="sub-title">About RRC History</span></div>
<div class="sub-content">
	<div class="history-about">
		The Ramblin' Reck has been on Georgia Tech's campus for over 80 years. It is an integral part of Tech's legacy but its history has never been compiled in one place. RRC History is an ongoing project to archive the history of the club. Each year has 4 sections:
		<ul>
			<li><b>Highlights:</b> historical events or accomplishemnts of the club during that year. Please try to keep highlights short and to the point.</li>
			<li><b>Members:</b> Members and Exec Board of the club by year. We are in the process of filling in past rosters.</li>
			<li><b>Stories:</b> Personal stories submitted by Members and Alumni.</li>
			<li><b>Pictures:</b> Photos from that year. All uploaded images are stored on the server so please be aware of the file size when uploading.</li>
		</ul>
        <b>This is not Facebook. Please do not upload every photo you have ever taken.</b>
	</div>
</div>

<div class="sub-header"><span class="sub-title">History Log</span></div>
<div class="sub-content">

<?php	
$log_query= $db->query("SELECT year,postDate,type,'stories' as tableName,Member.username FROM stories,Member WHERE deleted=0 AND stories.user = Member.memberID UNION SELECT year,postDate,'3' as type,'photos' as tableName,Member.username FROM photos,Member WHERE deleted=0 AND photos.userId = Member.memberID ORDER BY postDate DESC");
$log_query->execute();
?>

			<ul>
			<?php 
					while($row = $log_query->fetch()){
						if($row['type']==0){
							echo "<li>".$row['username']." added a highlight to year <a href=\"history.php?year=".$row['year']."\">".$row['year']."</a>.</li>";
						} else if($row['type']==1){
							echo "<li>".$row['username']." added a story to year <a href=\"history.php?year=".$row['year']."\">".$row['year']."</a>.</li>";
						} else{
							echo "<li>".$row['username']." added a photo to year <a href=\"history.php?year=".$row['year']."\">".$row['year']."</a>.</li>";
						}
					}
				?>
			</ul>
</div>