<div>



	<form action = 'index.php?c=main&a=testLoginForm' method = 'POST'>
		<div class="input">
			<label for="username">
				Nutzername
			</label>
			<input id="username" name="username" type="username" placeholder="username"  required />
		</div

		<div class="input">
			<label for="password">
				Passwort:
			</label>
			<input id="password" name="password" type="password" placeholder="passowrd" required />
		</div>

		<div class="input submit">
			<input name="submit" type="submit" value="Login"/>
		</div>
		<div class="login-footer">
			<a href="index.php?c=main&a=register">Konto erstellen</a>
		</div>
	</form>

</div>