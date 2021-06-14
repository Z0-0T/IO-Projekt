<?php

function navBar($active, $role) {
?>

<header class="topnav">
	<?php if($role != "NO") { ?>
		<a <?php if($active == "profile") { ?> class="active" <?php } ?> href="/app/profile.php">Profil</a>
	<?php } ?>
 
	<a <?php if($active == "home") { ?> class="active" <?php } ?> href="/app/index.php">Strona Główna</a>
	<a <?php if($active == "news") { ?> class="active" <?php } ?> href="/app/news.php">Nowości</a>
	<a <?php if($active == "contact") { ?> class="active" <?php } ?> href="/app/contact.php">Kontakt</a>
	<a <?php if($active == "about") { ?> class="active" <?php } ?> href="/app/about.php">O Nas</a>
  
  
	<?php if($role == "NO") { ?>
		<div class="topnav-right">
			<a href="login.php">Zaloguj</a>
			<a href="register.php">Zarejestruj się</a>
		</div>
	<?php } elseif($role == "KL") { ?>
		<div class="topnav-right">
			<a <?php if($active == "zamowienia") { ?> class="active" <?php } ?> href="/app/zamowienia.php">Zamówienia</a>
		</div>
	<?php } elseif($role == "OS") { ?>
		<div class="topnav-right">
			<a <?php if($active == "os") { ?> class="active" <?php } ?> href="/app/os/index.php">Operator Systemu</a>
		</div>
	<?php } elseif($role == "PI") { ?>
		<div class="topnav-right">
			<a <?php if($active == "pi") { ?> class="active" <?php } ?> href="/app/pi/index.php">Pilot</a>
		</div>
	<?php } elseif($role == "OD") { ?>
		<div class="topnav-right">
			<a <?php if($active == "od") { ?> class="active" <?php } ?> href="/app/od/index.php">Operator Danych</a>
		</div>
	<?php } elseif($role == "OL") { ?>
		<div class="topnav-right">
			<a <?php if($active == "ol") { ?> class="active" <?php } ?> href="/app/ol/index.php">Operator Lotów</a>
		</div>
	<?php } elseif($role == "OZ") { ?>
		<div class="topnav-right">
			<a <?php if($active == "oz") { ?> class="active" <?php } ?> href="/app/oz/index.php">Operator Zamówień</a>
		</div>
	<?php } ?>
  
</header> 

<?php
}
?>