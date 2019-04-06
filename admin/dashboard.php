<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');
if($_SESSION['uRole'] == "admin"){
}else{
	header("location: ../user/login.php");
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
	<link rel="stylesheet" href="./css/table.css">
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
				<table>
					<caption>Recently Signed Up Users (<a href="allUsers.php" style="color: red;">View All</a>)</caption>
					<thead>
						<tr>
							<th scope="col">Profile Photo</th>
							<th scope="col">Name</th>
							<th scope="col">Display Name</th>
							<th scope="col">Email</th>
						</tr>
					</thead>
					<tbody>
						<?php
						include "db.php";
						$query = "SELECT * FROM users ORDER BY uId DESC LIMIT 5";
						$select_users= mysqli_query($con,$query);
						while($row = mysqli_fetch_assoc($select_users)){
							$uId = $row['uId'];
							$uFirstName = $row['uFirstName'];
							$uLastName = $row['uLastName'];
							$uEmail = $row['uEmail'];
							$uProfilePic = $row['uProfilePic'];
							?>
							<tr>
								<td data-label="Account"><img src="../user/<?php echo $uProfilePic; ?>" height="50" width="50" style="border-radius:50%"></td>
								<td data-label="Due Date"><?php echo $uFirstName; ?></td>
								<td data-label="Amount"><?php echo $uFirstName; ?></td>
								<td data-label="Period"><?php echo $uFirstName; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>


				<table>
					<caption>Recently Uploaded Songs (<a href="allSongs.php" style="color: red;">View All</a>)</caption>
					<thead>
						<tr>
							<th scope="col">Song Image</th>
							<th scope="col">Title</th>
							<th scope="col">Artist</th>
							<th scope="col">Source</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$query = "SELECT * FROM songs ORDER BY sId DESC LIMIT 5";
						$select_songs= mysqli_query($con,$query);
						while($row = mysqli_fetch_assoc($select_songs)){
							$sId = $row['sId'];
							$sTitle = $row['sTitle'];
							$sImage = $row['sImage'];
							$sArtist = $row['sArtist'];
							$sSource = $row['sSource'];
							?>
							<tr>
								<td data-label="Account"><img src="<?php echo $sImage; ?>" height="50" width="50" style="border-radius:50%"></td>
								<td data-label="Due Date"><?php echo $sTitle; ?></td>
								<td data-label="Amount"><?php echo $sArtist; ?></td>
								<td data-label="Period"><?php echo $sSource; ?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</main>
	</div>

	<script type="text/javascript" src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

	<script type="text/javascript">

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