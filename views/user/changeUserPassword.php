<?php
    $error = '';

    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        $error = $_SESSION['error'];
    }
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
		<input class="btn" type="submit" name="submit" value="Speichern">
	</form>
    <label class="errorMessage"><?=$error?></label>
</div>