<!--<div>
	<form action = 'index.php?c=main&a=login' method = 'POST'>
		<div class="input">
			<label for="username">
				Nutzername
			</label>
			<input id="username"
                   name="username"
                   type="username"
                   placeholder="username"
                   required value=<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); //default Values?> >
		</div

		<div class="input">
			<label for="password">
				Passwort:
			</label>
			<input id="password"
                   name="password"
                   type="password"
                   placeholder="password"
                   required value=<?php echo (isset($_POST['passowrd']) ? $_POST['passowrd'] : ''); //default Values?> >
		</div>

		<div class="input submit">
			<input name="submit"
                   type="submit"
                   value="Login">
		</div>
		<div class="login-footer">
			<a href="index.php?c=main&a=register">Konto erstellen</a>
		</div>
	</form>

</div>-->

<?php
    if (isset($_SESSION['makeOrder']) && !empty($_SESSION['makeOrder'])) {
        $guest = '<a href="index.php?c=main&a=register'.DIRECTORY_SEPARATOR.'guest">Als Gast fortfahren</a>';
//        $_SESSION['guest'] = true;
    } else {
	    $guest = '';
    }
?>

<div class = "InputBox">
    <form action = 'index.php?c=main&a=login' method = 'POST'>
        <h3>Login</h3>
        <div class = "InputLine">
			<input id="username"
                   name="username"
                   type="username"
                   placeholder="Username"
                   required value=<?php echo (isset($_POST['username']) ? $_POST['username'] : ''); //default Values?> >
        </div>

        <br>

        <div class = "InputLine">
			<input id="password"
                   name="password"
                   type="password"
                   placeholder="Password"
                   required value=<?php echo (isset($_POST['passowrd']) ? $_POST['passowrd'] : ''); //default Values?> >
        </div>

        <br>

		<div class="input submit">
			<input name="submit"
                   type="submit"
                   value="Login">
		</div>
        <br>
		<div class="login-footer">
			<a href="index.php?c=main&a=register">Konto erstellen</a>

            <?=$guest?>
		</div>
    </form>
</div>