<?php
error_reporting(-1);
ini_set('display_errors', 'On');
session_start();
if($_SESSION['uRole'] == "user"	){
}
else {
	header("location: login.php");
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
	<link rel="stylesheet" href="../admin/css/style.css">
	<link rel="stylesheet" type="text/css" href="css/searchBox.css">
	<style type="text/css">
		#playlist,audio{background:#55CAF5;width:400px;padding:20px;}
		#playlist{margin-top:-2px;}
		.active a{color:#5DB0E6;}
		li{list-style:none;text-decoration:}
		li a{color:#eeeedd;background:#333;padding:5px;display:block;text-decoration:none;}
		li a:hover{color:#5DB0E6;}
		.last{
			display: none;
		}
	</style>

</head>
<body>


	<?php
	include "header.php";
	?>

	<div class="mdc-drawer-scrim"></div>
	<div class="mdc-drawer-app-content">
		<?php include "navbar.php"; ?>
		<main class="main-content" id="main-content">
			<div class="mdc-top-app-bar--fixed-adjust">
				<!-- main section ******************* -->
				<div class="mdc-layout-grid">
					<div class="mdc-layout-grid__inner">
						<div class="mdc-layout-grid__cell--span-3"></div>
						<div class="mdc-layout-grid__cell--span-6">

							<?php 			require "db.php";
							if(isset($_GET['playlistDetail'])){
								$playlistId = $_GET['playlistDetail'];


								$query = "SELECT * FROM playlist WHERE pId=$playlistId";
								$playlist= mysqli_query($con,$query);
								while($row = mysqli_fetch_assoc($playlist)){
									$pName = $row['pName'];
								}
								?>
								<h2>Playlist: <?php echo $pName;  ?></h2>

								<?php
								$query = "SELECT * FROM playlistSong WHERE pId=$playlistId LIMIT 1";
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
								</div>
							</div>
						</div>
						<div class="mdc-layout-grid">
							<div class="mdc-layout-grid__inner">
								<div class="mdc-layout-grid__cell--span-3"></div>
								<div class="mdc-layout-grid__cell--span-6">
									<nav role='navigation'>
										<ul id="playlist">
											<?php

											$query = "SELECT * FROM playlistSong WHERE pId=$playlistId";
											$select_song_id= mysqli_query($con,$query);
											while($row = mysqli_fetch_assoc($select_song_id)){
												$song_id = $row['sId'];

												$query = "SELECT * FROM songs WHERE sId=$song_id ";
												$select_song= mysqli_query($con,$query);
												$checkrows=mysqli_num_rows($select_song);

												if ($checkrows == 0) {
													echo "<h3>No songs for this playlist! Pls added songs to it.</h3>";
												}else{
													while($row = mysqli_fetch_assoc($select_song)){
														$song = $row['sSong'];
														$songTitle = $row['sTitle'];

														?>
														<li>
															<a href="../admin/<?php echo $song ?>">
																<?php echo $songTitle;  ?>
															</a>
															<hr>
														</li>
														<?php 
													}
												}
											}
											?>
											<li class="last">
												<a href="">
													none
												</a>
											</li>
										</ul>
									</nav>
								</div>
							</div>
						</div>
						<?php

					}else if(isset($_GET['songList'])){
						$the_playlist_id = $_GET['songList'];
						?>

						<div class="mdc-layout-grid">
							<div class="mdc-layout-grid__inner">
								<div class="mdc-layout-grid__cell--span-1"></div>
								<div class="mdc-layout-grid__cell--span-8">
									<nav role='navigation'>
										<?php 
										$query = "SELECT * FROM playlist WHERE pId=$the_playlist_id";
										$playlist= mysqli_query($con,$query);
										while($row = mysqli_fetch_assoc($playlist)){
											$pName = $row['pName'];
										}
										?>
										<?php echo "<a href='viewDetailsPlaylist.php?playlistDetail=$the_playlist_id' style='text-decoration: none'>"  ?>
										<button type="button" class="mdc-button mdc-button--raised">
											<span class="mdc-button__label">Play</span>
										</button>
									</a>
									<h2>Playlist: <?php echo $pName;  ?></h2>

									<ul id="playlist" align="center">
										<?php
										$query = "SELECT * FROM playlistSong WHERE pId=$the_playlist_id";
										$select_song_id= mysqli_query($con,$query);
										while($row = mysqli_fetch_assoc($select_song_id)){
											$song_id = $row['sId'];

											$query = "SELECT * FROM songs WHERE sId=$song_id ";
											$select_song= mysqli_query($con,$query);
											$checkrows=mysqli_num_rows($select_song);

											if ($checkrows == 0) {
												echo "<h3>No songs for this playlist! Pls added songs to it.</h3>";
											}else{
												while($row = mysqli_fetch_assoc($select_song)){
													$song = $row['sSong'];
													$songTitle = $row['sTitle'];

													?>
													<li>
														<a href="../admin/<?php echo $song ?>">
															<?php echo $songTitle;  ?>
														</a>
														<hr>
													</li>

													<?php
												}
											}
										}?>
									</ul>
								</nav>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</main>
	</div>
	<script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
	<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>


	<script type="text/javascript">
		var audio;
		var playlist;
		var tracks;
		var current;

		init();
		function init(){
			current = 1;
			audio = $('#audio');
			playlist = $('#playlist');
			tracks = playlist.find('li a');
			len = tracks.length - 1;
			audio[0].volume = 0.5;
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