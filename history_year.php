<?php
	$highlights_query= $db->prepare("SELECT id,user,title FROM stories WHERE type=0 AND year=:year AND deleted=0");
	$highlights_query->bindValue("year",$yearPage, PDO::PARAM_STR);
	$highlights_query->execute();
?>
<div id="highlights">
	<div class="sub-header"><span class="sub-title">Highlights</span><span id="addHighlight_btn" class="addBtn">ADD</span></div>
	<div class="sub-content">
		<?php if($highlights_query->rowCount()==0): ?>
			<div class="empty_highlight">Currently no highlights. Be the first to add one!</div>

		<?php endif ; ?>
		<ul>
			<?php 
				while($row = $highlights_query->fetch()){
					 echo "<li>".$row['title'];
					 if($_SESSION['isAdmin']==1 || $_SESSION['memberID']==$row['user']){echo "<a class=\"delete\" data-href=\"deleteStory.php?id=".$row['id']."&year=".$yearPage."\"></a>";}
					 echo "</li>";
				}
			?>
			<!-- <li>Georgia Tech Football attended the Sun Bowl (El Paso) for the second year in a row. The Reck was trailed across the country to be at the game.  </li>
			<li>The Dean Dull Endowment reaches $100,000.</li> -->
		</ul>
	</div>
</div>

	<div class="sub-header"><span class="sub-title">Members</span></div>
<div class="roster">
	<div class="exec">
		<table>
			<tr>
				
				<td>Driver</td>
				<?php
					$driver_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=1 AND Member.memberID=HoldsPosition.memberID");
					$driver_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$driver_query->execute();
					$driver = $driver_query->fetch();
				?>
				<td><?php echo $driver['firstName']." ".$driver['lastName'] ?></td>
			</tr>
			<tr>
				<?php
					$president_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=11 AND Member.memberID=HoldsPosition.memberID");
					$president_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$president_query->execute();
					$president = $president_query->fetch();
				?>
				<td>President</td>
				<td><?php echo $president['firstName']." ".$president['lastName'] ?></td>
			</tr>
			<tr>
				<?php
					$position_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=21 AND Member.memberID=HoldsPosition.memberID");
					$position_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$position_query->execute();
					$position = $position_query->fetch();
				?>
				<td>Vice-President</td>
				<td><?php echo $position['firstName']." ".$position['lastName'] ?></td>
			</tr>
			<tr>
				<?php
					$position_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=41 AND Member.memberID=HoldsPosition.memberID");
					$position_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$position_query->execute();
					$position = $position_query->fetch();
				?>
				<td>Treasurer</td>
				<td><?php echo $position['firstName']." ".$position['lastName'] ?></td>
			</tr>
			<tr>
				<?php
					$position_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=31 AND Member.memberID=HoldsPosition.memberID");
					$position_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$position_query->execute();
					$position = $position_query->fetch();
				?>
				<td>Secretary</td>
				<td><?php echo $position['firstName']." ".$position['lastName'] ?></td>
			</tr>
			<tr>
				<?php
					$position_query= $db->prepare("SELECT firstName,lastName FROM Member,HoldsPosition WHERE HoldsPosition.year=:year AND HoldsPosition.positionID=51 AND Member.memberID=HoldsPosition.memberID");
					$position_query->bindValue("year",$yearPage, PDO::PARAM_STR);
					$position_query->execute();
					$position = $position_query->fetch();
				?>
				<td>MALs</td>
				<td><?php echo $position['firstName']." ".$position['lastName']." & "; $position = $position_query->fetch(); echo $position['firstName']." ".$position['lastName']?></td>
			</tr>

		</table>
	</div>
	<?php
		$members_query= $db->prepare("SELECT * FROM Member WHERE :year BETWEEN joinYear AND gradYear ORDER BY lastName ASC");
		$members_query->bindValue("year",$yearPage, PDO::PARAM_STR);
		$members_query->execute();
	?>
	<ul class="member-list">
		<?php 
			while($row = $members_query->fetch()){
				 echo "<li>".$row['firstName']." ".$row['lastName']."</li>";
			}
		?>
	</ul>
</div>
<?php
	$stories_query= $db->prepare("SELECT stories.id,title,postdate,username FROM stories,Member WHERE type=1 AND stories.year=:year AND Member.memberID = stories.user AND deleted=0");
	$stories_query->bindValue("year",$yearPage, PDO::PARAM_STR);
	$stories_query->execute();
?>
<div id="stories">
	<div class="sub-header"><span class="sub-title">Stories</span><span class="sub-sub-title">(click to expand)</span><span id="addStory_btn" class="addBtn">ADD</span></div>
	<div class="sub-content">

		<?php if($stories_query->rowCount()==0): ?>
			<div class="empty_highlight">Currently no stories. Be the first to add one!</div>
		<?php endif ; ?>
		<ul id="stories_list">
			<?php 
				while($row = $stories_query->fetch()){
					$date = date('m.d.y',strtotime($row['postdate']));
					 echo "<li id=\"story_".$row['id']."\"data-id=\"".$row['id']."\"><span class=\"title\">".$row['title']."</span><div class=\"feature-text hide\"></div><div class=\"feature-meta hide\">Submitted by <a href=\"\">".$row['username']."</a> on ".$date."</div>";
					 if($_SESSION['isAdmin']==1 || $_SESSION['username']==$row['userId']){echo "<a class=\"edit\"></a><a class=\"delete\" data-href=\"deleteStory.php?id=".$row['id']."&year=".$yearPage."\"></a>";}
					 echo "</li>";
				}
			?>

				<!-- <li>McCamish Pavillion opened for the first time.</li>
				<li>Reck Clubbers are interview for a Reeses commercial about George P. Burdell</li>
				<li class="feature">The Reck is featured on the cover of the alumni magazine.
					<div class="feature-text">Morbi vulputate ante ac mauris feugiat et viverra orci imperdiet. Etiam sit amet felis id dolor ultricies ultrices. Fusce tincidunt lobortis erat a dictum. Pellentesque in nisl egestas nunc porttitor ultrices. Nulla facilisi. Cras massa lectus, vestibulum eu interdum eget, gravida id dolor. Nunc luctus augue velit. Pellentesque aliquet dui ut nisi ornare vitae molestie est sollicitudin. Nunc purus libero, malesuada sit amet aliquet ut, consequat non risus. In at neque sed metus faucibus aliquet vitae vel elit. Curabitur ultrices justo ut nunc pellentesque lobortis. Aenean sed purus odio.</div>
					<div class="feature-meta">Submited by <a href="">bahlers9</a> on 6.3.2013</div>
				</li>	
				<li>McCamish Pavillion opened for the first time.</li>
				<li>Reck Clubbers are interview for a Reeses commercial about George P. Burdell</li> -->
			</ul>
	</div>
</div>
<div id="pics">
	<div class="sub-header"><span class="sub-title">Pictures</span><span id="addImage_btn" class="addBtn">ADD</span></div>
	<div class="sub-content">
		<div id="pics_container">
			<?php
				$pics_query= $db->prepare("SELECT id,userId,img_path,caption FROM photos WHERE year=:year AND deleted=0");
				$pics_query->bindValue("year",$yearPage, PDO::PARAM_STR);
				$pics_query->execute();
			?>
			<?php if($pics_query->rowCount()==0): ?>
				<div class="empty_images">Currently no pictures. Be the first to add one!</div>
			<?php endif ; ?>
			<?php 
					while($row = $pics_query->fetch()){
						 echo "<div class=\"item-wrap\" ><a href=\"".$row['img_path']."\" title=\"".$row['caption']."\" class=\"item\"><img src=\"".$row['img_path']."\" class=\"img_thumb\"></a>";
						 if($_SESSION['isAdmin']==1 || $_SESSION['memberID']==$row['userId']){echo "<a class=\"delete-image\" data-href=\"deleteImage.php?id=".$row['id']."&year=".$yearPage."\"></a>";}
						 echo "</div>";
					}
				?>
		</div>
	</div>
</div>
