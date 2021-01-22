<div>
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
                   placeholder="passowrd"
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

</div>