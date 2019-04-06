<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
if($_SESSION['uRole'] == "admin"){
}else{
	header("location: ../user/login.php");
}
?>

<?php
include "db.php";
if(isset($_GET['deleteSong'])){
	$the_song_id = $_GET['deleteSong'];

	$query = "DELETE FROM songs WHERE sId = {$the_song_id}";
	$delete_query = mysqli_query($con, $query) or die("Delete Error!" . mysqli_error($con));
	header("Location: allSongs.php");
}
?>

<?php
if(isset($_GET['addToCategory'])){
	$song_id = $_GET['addToCategory'];
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
	<link rel="stylesheet" href="./css/style.css">
	<style type="text/css">
		.mdc-layout-grid{
			padding-left: 0px;
		}

		#spanHeading{
			font-weight: bolder;
		}
	</style>
</head>

<body>

	<aside class="mdc-drawer mdc-drawer--modal">
		<div class="mdc-drawer__content">
			<nav class="mdc-list">
				<a class="mdc-list-item mdc-list-item--activated" href="dashboard.php" aria-selected="true">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">inbox</i>
					<span class="mdc-list-item__text">Dashboard</span>
				</a>
				<a class="mdc-list-item" href="addSong.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">Add Songs</span>
				</a>
				<a class="mdc-list-item" href="category.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">Category</span>
				</a>
				<a class="mdc-list-item" href="allUsers.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">send</i>
					<span class="mdc-list-item__text">All Users</span>
				</a>
				<a class="mdc-list-item" href="allSongs.php">
					<i class="material-icons mdc-list-item__graphic" aria-hidden="true">drafts</i>
					<span class="mdc-list-item__text">All Songs</span>
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
		<header class="mdc-top-app-bar app-bar" id="app-bar">
			<div class="mdc-top-app-bar__row">
				<section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
					<a href="#" class="demo-menu material-icons mdc-top-app-bar__navigation-icon">menu</a>
					<span class="mdc-top-app-bar__title">Signal Play</span>
				</section>
			</div>
		</header>
		<main class="main-content" id="main-content" style="margin-top: 50px;">
			<div class="mdc-top-app-bar--fixed-adjust">
				<h1>All Songs</h1>
				<div class="mdc-layout-grid">
					<div class="mdc-layout-grid__inner">
						<?php
						$query = "SELECT * FROM songs";
						$select_songs= mysqli_query($con,$query);
						while($row = mysqli_fetch_assoc($select_songs)){
							$sId = $row['sId'];
							$uId = $row['uId'];
							$sSong = $row['sSong'];
							$sTitle = $row['sTitle'];
							$sArtist = $row['sArtist'];
							$sImage = $row['sImage'];
							$sSource = $row['sSource'];
							$sDescription = $row['sDescription'];
							$sDuration = $row['sDuration'];

							
							?>

							<div class="mdc-layout-grid__cell--span-4">
								<div class="mdc-card demo-card">
									<div class="mdc-card__primary-action demo-card__primary-action contentCard" tabindex="0">
										<div class="mdc-card__media mdc-card__media--8-3 demo-card__media userProfilePic">
											<?php
											echo "<a href='allSongs.php?deleteSong=$sId' onClick=\"javascript: return confirm('Are you sure you want to delete?');\"><button class='mdc-button mdc-card__action mdc-card__action--button blockButton ' style='background-color:#fb535b!important;font-size:10px '>Delete</button></a>";
											?>
											<?php
											echo "<a href='addSongToCategory.php?addToCategory=$sId'><button class='mdc-button mdc-card__action mdc-card__action--button blockButton ' style='background-color:black!important;font-size:10px' onCLick='dialog.open()''>Update Category</button></a>";
											?>
											<img src="<?php echo $sImage; ?>" width="150px" height="150px">
										</div>
										<div class="demo-card__primary">
											<h2 class="demo-card__title mdc-typography mdc-typography--headline6"><?php echo $sTitle . " " . "by " . $sArtist ;?></h2>
											<h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2"><span id="spanHeading">Source:</span><?php echo $sSource; ?></h3>
											<h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2"><span id="spanHeading">Description:</span> <?php echo $sDescription; ?></h3>

											<?php 
											$query = "SELECT * FROM catSongs WHERE sId = $sId";
											$select_song_category= mysqli_query($con,$query);
											$checkrows=mysqli_num_rows($select_song_category);

											if($checkrows == 0){
														?>

														<h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2"><span id="spanHeading">Category:</span> None</h3>
														<?php
											}else{
												while($row = mysqli_fetch_assoc($select_song_category)){
													$cId = $row['cId'];

													$query = "SELECT * FROM category WHERE cId = $cId";
													$select_song_category_name= mysqli_query($con,$query);
													while($row = mysqli_fetch_assoc($select_song_category_name)){
														$cName = $row['cName'];
														?>

														<h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2"><span id="spanHeading">Category:</span> <?php echo $cName; ?></h3>
														<?php
													}
												}
											}
											?>
										</div>
									</div>
									<div class="mdc-card__actions">
										<div class="mdc-card__action-buttons actionBlock">
											<audio src="<?php echo $sSong; ?>"></audio>
											<audio controls style="padding-right: 5px;">
												<source id="audioSTARTMP3" src="<?php echo $sSong; ?>" type="audio/mpeg">
												</audio>

											</div>
											<?php
											echo "<a href='editSong.php?editSong=$sId'><button class='mdc-button mdc-card__action mdc-card__action--button blockButton'>Edit</button></a>";
											?>
										</div>
									</div>
								</div>
								<?php
							}
							?>	
						</div>
					</div>
				</div>

				<!-- modal category ************** -->

				<div class="mdc-dialog"
				role="alertdialog"
				aria-modal="true"
				aria-labelledby="my-dialog-title"
				aria-describedby="my-dialog-content">
				<div class="mdc-dialog__container">
					<form method="POST" enctype="multipart/form-data">
						<div class="mdc-dialog__surface">
							<h2 class="mdc-dialog__title" id="my-dialog-title">Add Category
							</h2>
							<div class="mdc-dialog__content" id="my-dialog-content">
								<div class="mdc-layout-grid">
									<div class="mdc-layout-grid__inner">
										<div class="mdc-layout-grid__cell--span-12">
											<div class="mdc-layout-grid">
												<div class="mdc-layout-grid__inner">
													<div class="mdc-layout-grid__cell--span-12">
														<div class="mdc-text-field mdc-text-field--outlined mdc-text-field--no-label email">
															<input type="text" name="cName" size="30" class="mdc-text-field__input" aria-label="Label" placeholder="Category Name">
															<div class="mdc-notched-outline">
																<div class="mdc-notched-outline__leading"></div>
																<div class="mdc-notched-outline__trailing"></div>
															</div>
														</div>
													</div>	
												</div>
											</div>

										</div>	
									</div>
								</div>

								<div class="mdc-layout-grid">
									<div class="mdc-layout-grid__inner">
										<div class="mdc-layout-grid__cell--span-12">
											<div class="mdc-layout-grid">
												<div class="mdc-layout-grid__inner">
													<div class="mdc-layout-grid__cell--span-12">
														<div class="mdc-text-field mdc-text-field--outlined mdc-text-field--no-label email">
															<input type="text" name="cDescription" size="30" class="mdc-text-field__input" aria-label="Label" placeholder="Category Description">
															<div class="mdc-notched-outline">
																<div class="mdc-notched-outline__leading"></div>
																<div class="mdc-notched-outline__trailing"></div>
															</div>
														</div>
													</div>	
												</div>
											</div>
										</div>	
									</div>
								</div>

								<div class="mdc-layout-grid">
									<div class="mdc-layout-grid__inner">
										<div class="mdc-layout-grid__cell--span-12">
											<div class="mdc-text-field mdc-text-field--outlined mdc-text-field--no-label email">
												<div class="mdc-layout-grid">
													<div class="mdc-layout-grid__inner">
														<div class="mdc-layout-grid__cell--span-4" style="margin-top: 10px;">
															Add Image: 
														</div>
														<div class="mdc-layout-grid__cell--span-8">
															<input type="file" name="cImage" size="30" class="mdc-text-field__input" aria-label="Label" placeholder="Song Image" accept="image/*;capture=camera" style="padding-left: 0">
														</div>
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
							<footer class="mdc-dialog__actions">
								<button type="button" class="mdc-button mdc-dialog__button" data-mdc-dialog-action="no">
									<span class="mdc-button__label">Cancel</span>
								</button>
								<button type="submit" name="submit" class="mdc-button mdc-dialog__button mdc-dialog__button--default" data-mdc-dialog-action="yes">
									<span class="mdc-button__label">Add</span>
								</button>
							</footer>
						</div>
					</form>
				</div>
				<div class="mdc-dialog__scrim">

				</div>
			</div>
			<!-- modal category end ************** -->
		</main>
	</div>

	<script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

	<script type="text/javascript">
		const dialog = new mdc.dialog.MDCDialog(document.querySelector('.mdc-dialog'));

		document.addEventListener('play', function(e){
			var audios = document.getElementsByTagName('audio');
			for(var i = 0, len = audios.length; i < len;i++){
				if(audios[i] != e.target){
					audios[i].pause();
				}
			}
		}, true);

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