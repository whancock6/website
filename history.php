<?php
	require "logged_in_check.php";
	require "set_session_vars_full.php";
	require "database_connect.php";
?>


<?php
$yearPage = $_GET['year'];

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Ramblin' Reck Club</title>
		<link rel="stylesheet" href="css/reset.css" type="text/css">
		<link rel="stylesheet" href="css/history.css" type="text/css">
		<link rel="stylesheet" href="css/redactor.css" type="text/css">
		<link href="css/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/magnific-popup.css">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans|Roboto+Slab:400,300,700' rel='stylesheet' type='text/css'>

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
		<script src="js/imagesloaded.pkgd.min.js"></script>
		<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
		<!--<script src="js/jquery.mCustomScrollbar.min.js"></script>-->
		<script src="js/redactor.min.js"></script>
		<script src="js/jquery.magnific-popup.min.js"></script>
		<script src="js/masonry.pkgd.min.js"></script>
		
		<script>
		$(document).ready(function(){
			$("#year_nav").mCustomScrollbar({
			    horizontalScroll:true,
			    theme:"dark",
			});
			$("#year_nav").mCustomScrollbar("scrollTo","#<?php echo $yearPage ?>");


			$('#stories_list li').click(function(){
				$(this).toggleClass('feature');
				$(this).children('.feature-text').toggleClass("hide");
				$(this).children('.feature-meta').toggleClass("hide");
				var storyId = $(this).data('id');
				$.ajax({
				  type: "GET",
				  url: "storyAJAX.php",
				  data: {id:storyId},
				  cache: false,
				  success: function(data){
				  	//alert(storyId);
				     var id="#story_"+storyId;
				    $(id).children('.feature-text').html(data).text();
				  }
				});
			});
			$("#addHighlight_btn").click(function(){
				$("#mask").fadeIn();
				$("#overlay").fadeIn();
				$("#addHighlight").show();
			});
			$("#addStory_btn").click(function(){
				$("#mask").fadeIn();
				$("#overlay").fadeIn();
				$("#addStory").show();
			});
			$("#addImage_btn").click(function(){
				$("#mask").fadeIn();
				$("#overlay").fadeIn();
				$("#addImage").show();
			});
			$('.delete').click(function(){
				var href=$(this).data('href');
				$('.yes_btn').attr('href',href);
				$("#mask").fadeIn();
				$("#overlay").fadeIn();
				$("#delete_prompt").show();
			});
			$('.delete-image').click(function(){
				var href=$(this).data('href');
				$('.yes_btn').attr('href',href);
				$("#mask").fadeIn();
				$("#overlay").fadeIn();
				$("#delete_prompt").show();
			});

			
			$('#wysiwyg').redactor();

			$('.closeBtn').click(function(){
				$('#overlay').fadeOut();
				$('#mask').fadeOut();
				$("#addHighlight").hide();
				$("#addStory").hide();
				$("#addImage").hide();
				$("#delete_prompt").hide();
			});

			$(function() {
				var $container = $('#pics_container');

				// initialize
				$container.imagesLoaded( function() {
					$container.masonry({
					  itemSelector: '.item-wrap'
					});
				});
			});

			$('.item').magnificPopup({type:'image',titleSrc: 'title'});

		});
		</script>
	</head>
	<body>
		
		<div id="wrapper">
			<div id="container">
				<nav>
					<div class="leftNav">
						<span><a href="points.php">Home</a></span>
						<span><a href="history.php" class="highlight">History</a></span>
					</div>
					<div class="rightNav">
						<span class="club_title">Ramblin' Reck Club</span><br>
						<span class="meta">Logged in as <?php echo $_SESSION[username] ?></span>
					</div>
					<div id="year_nav">
						<ul>
							<?php
								foreach(range(intval(date('Y')),1930) as $year){
									echo "<li id=\"".$year."\"><a href=\"history.php?year=".$year."\"";
									if(intval($yearPage)==$year){
										echo "class=\"current\"";
									}
									echo ">".$year."</a></li>";
								}
							?>
						</ul>
						<script>
							 //
						</script>
					<div>
				</nav>
				<?php
					if($yearPage!=""){
						require "history_year.php";
					} else{
						require "history_log.php";
					}
				?>
				<div style="clear:both;"></div>
<footer>
	&copy; Copyright 2014 Ramblin' Reck Club. All Rights Reserved.
</footer>
			</div>
		</div>
		<div id="mask">
			<div id="overlay">
				<div id="addHighlight">
					<header>
						<h1>Add <?php echo $yearPage; ?> Highlight</h1>
						<a class="closeBtn">x</a>
					</header>
					<form action="process.php?type=0&year=<?php echo $yearPage?>" method="post" >
						<input type="hidden" name="user" value="<?php echo $_SESSION[memberID] ?>">

						<textarea name="title"></textarea>
						<input type="submit"></input>
					</form>
				</div>
				<div id="addStory">
					<header>
						<h1>Add <?php echo $yearPage; ?> Story</h1>
						<a class="closeBtn">x</a>
					</header>
					<form action="process.php?type=1&year=<?php echo $yearPage?>" method="post" >
						<div class="field">
						<label>Title</label>
						<input type="text" name="title">
						</div>
						<input type="hidden" name="user" value="<?php echo $_SESSION[memberID] ?>">

						<div class="field">
						<label>Story</label>
						<textarea name="story" id="wysiwyg"></textarea>
						</div>
						<input type="submit"></input>
					</form>
				</div>
				<div id="addImage">
					<header>
						<h1>Add <?php echo $yearPage; ?> Image</h1>
						<a class="closeBtn">x</a>
					</header>
   					<form id="Upload" action="upload.processer.php" enctype="multipart/form-data" method="post"> 
						<div class="field">
							<label>Caption</label>
							<textarea name="caption"></textarea>
						</div>
						<div class="field">
							<input id="file" type="file" name="file"> 
						</div>
						<input type="hidden" name="user" value="<?php echo $_SESSION[memberID] ?>">
						<input type="hidden" name="year" value="<?php echo $yearPage?>">
						<div class="field">
            				<input id="submit" type="submit" name="submit" value="Upload me!"> 

						</div>
					</form>
				</div>
				<!--<div id="editStory">
					<header>
						<h1>Edit <?php echo $yearPage; ?> Story</h1>
						<a class="closeBtn">x</a>
					</header>
					<form action="process.php?type=2&year=<?php echo $yearPage?>" method="post" >
						<div class="field">
						<label>Title</label>
						<input type="text" name="title">
						</div>
						<div class="field">
						<label>Story</label>
						<textarea name="story" id="wysiwyg"></textarea>
						</div>
						<input type="submit"></input>
					</form>
				</div>-->
				<div id="delete_prompt">
					<header>
						<h1>Are you sure you want to delete???</h1>
						<a class="closeBtn">x</a>
					</header>
					<div class="delete_btns"><a class="yes_btn" href="">DELETE</a> <a class="no_btn" href="">CANCEL</a></div>
					
				</div>
			</div>
		</div> 
	</body>
</html>