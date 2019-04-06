<?php
session_start();
if($_SESSION['uRole'] == "user"){
}
else {
	header("location: login.php");
}

if(isset($_GET['categoryDetail'])){
	$categoryId = $_GET['categoryDetail'];
}

include "db.php";

$query = "SELECT * FROM category WHERE cId=$categoryId";
$category= mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($category)){
	$cName = $row['cName'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<style type="text/css" href="css/table.css"></style>
	<style type="text/css">
		input[type="search"] {
			box-sizing: border-box;
		}
		.container {
			width: 400px;
			margin: 50px auto;
		}

		.Search {
			position: relative;
			display: flex;
			font-weight: 300;
			font-size: 40px;
			color: #555;
		}

		.Search-box {
			flex: 1 0 auto;
			margin: 0 12px;
			padding: 8px 20px;
			height: 35px;
			border: 0;
			box-shadow: 0 3px 12px -1px rgba(0, 0, 0, .3);
		}

		.Search-label {
			position: absolute;
			top: 14px;
			right: 30px;
			font-size: 40px;
			transition: all .15s ease-in-out;
		}

		#playlist,audio{background:#55CAF5;width:400px;padding:20px;}
		#playlist{margin-top:-2px;}
		.active a{color:#5DB0E6;}
		li{list-style:none;text-decoration:}
		li a{color:#eeeedd;background:#333;padding:5px;display:block;text-decoration:none;}
		li a:hover{color:#5DB0E6;}
	</style>
</style>
</head>
<body>


	<aside class="mdc-drawer mdc-drawer--modal">
		<div class="mdc-drawer__content">
			<nav class="mdc-list">
				<a class="mdc-list-item mdc-list-item--activated" href="index.php" aria-selected="true">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">inbox</i>
					<span class="mdc-list-item__text">Home</span>
				</a>
				<a class="mdc-list-item" href="addSong.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">send</i>
					<span class="mdc-list-item__text">Add Songs</span>
				</a>
				<a class="mdc-list-item" href="playlist.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">My Playlist</span>
				</a>
				<a class="mdc-list-item" href="mySongs.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">My Songs</span>
				</a>
				<a class="mdc-list-item" href="myProfile.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">Profile</span>
				</a>
				<a class="mdc-list-item" href="logout.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">Log Out</span>
				</a>
			</nav>
		</div>
	</aside>
	<div class="mdc-drawer-scrim"></div>
	<div class="mdc-drawer-app-content">
		<header class="mdc-top-app-bar app-bar" style="background-color: #0b0b0b" id="app-bar">
			<div class="mdc-top-app-bar__row">
				<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
					<a href="#" class="demo-menu material-icons mdc-top-app-bar__navigation-icon">menu</a>
					<span class="mdc-top-app-bar__title">Welcome <?php echo $_SESSION['uEmail']; ?></span>

				</section>
				<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end">
					<div class="container">
						<form action="search.php" method="GET" class="Search">
							<input class="Search-box" type="search" name="query" id="Search-box" autocomplete="off">
							<label class="Search-label" for="Search-box"><i class="fa fa-search"></i></label>
							<button type="submit" name="submit" class="mdc-button mdc-button--raised">
								<span class="mdc-button__label">Search</span>
							</button>
						</form>
					</div>

				</section>
			</div>
		</header>
		<main class="main-content" id="main-content">
			<div class="mdc-top-app-bar--fixed-adjust">
				<h2>Category: <?php echo $cName;  ?></h2>
				<?php

				$query = "SELECT * FROM catSongs WHERE cId=$categoryId LIMIT 1";
				$select_song_id= mysqli_query($con,$query);
				while($row = mysqli_fetch_assoc($select_song_id)){
					$song_id = $row['sId'];

					$query = "SELECT * FROM songs WHERE sId=$song_id ";
					$select_song= mysqli_query($con,$query);
					while($row = mysqli_fetch_assoc($select_song)){
						$song = $row['sSong'];

						?>
						<audio id="audio" preload="auto" tabindex="0" controls="">
							<source src="../admin/<?php echo $song; ?>">
								Your Fallback goes here
							</audio>
							<?php
						}
					}
					?>
					<nav role='navigation'>
						<ul id="playlist">
							<?php

							$query = "SELECT * FROM catSongs WHERE cId=$categoryId";
							$select_song_id= mysqli_query($con,$query);
							while($row = mysqli_fetch_assoc($select_song_id)){
								$song_id = $row['sId'];

								$query = "SELECT * FROM songs WHERE sId=$song_id ";
								$select_song= mysqli_query($con,$query);
								while($row = mysqli_fetch_assoc($select_song)){
									$song = $row['sSong'];
									$songTitle = $row['sTitle'];

									?>
									<li class="active">
										<a href="../admin/<?php echo $song ?>">
											<?php echo $songTitle;  ?>
										</a>
										<hr>
									</li>
									<?php 
								}
							}
							?>
						</ul>
					</nav>
				</div>
			</main>
			<script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
			<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
			
			<script type="text/javascript">
				var audio;
				var playlist;
				var tracks;
				var current;

				init();
				function init(){
					current = 0;
					audio = $('audio');
					playlist = $('#playlist');
					tracks = playlist.find('li a');
					len = tracks.length - 1;
					audio[0].volume = .10;
					audio[0].play();
					playlist.find('a').click(function(e){
						e.preventDefault();
						link = $(this);
						current = link.parent().index();
						run(link, audio[0]);
					});
					audio[0].addEventListener('ended',function(e){
						current++;
						if(current == len){
							current = 0;
							link = playlist.find('a')[0];
						}else{
							link = playlist.find('a')[current];    
						}
						run($(link),audio[0]);
					});
				}
				function run(link, player){
					player.src = link.attr('href');
					par = link.parent();
					par.addClass('active').siblings().removeClass('active');
					audio[0].load();
					audio[0].play();
				}

				const topAppBar = mdc.topAppBar.MDCTopAppBar.attachTo(document.getElementById('app-bar'))
				const drawer = mdc.drawer.MDCDrawer.attachTo(document.querySelector('.mdc-drawer'))

				const listEl = document.querySelector('.mdc-drawer .mdc-list');
				const mainContentEl = document.querySelector('.main-content');

				topAppBar.setScrollTarget(document.getElementById('main-content'))
				topAppBar.listen('MDCTopAppBar:nav', () => {
					drawer.open = !drawer.open
				})

				listEl.addEventListener('click', (event) => {
					drawer.open = false;
				});

			</script>
		</body>
		</html>