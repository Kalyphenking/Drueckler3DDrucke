<?php
//include_once (VIEWSPATH.'user'.DIRECTORY_SEPARATOR.'userMenuBar.php');
?>

<div class="userContent">
	<form action="index.php?c=user&a=changeUserPassword" method = 'POST'>
		Aktuelles Passwort:
		<input type="password" name="currentPassword" required>
		<br>
		Neues Passwort:
		<input type="password" name="newPasswort" required>
		<br>
		Passwort wiederholen:
		<input type="password" name="newPasswortVerified" required>
        <br>
		<input type="submit" name="submit" value="Speichern">
	</form>
</div>