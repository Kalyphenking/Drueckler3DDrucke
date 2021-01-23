<div>
	<form action = 'index.php?c=main&a=register' method = 'POST'>


		<div class="input">
			<label for="firstName">
				Nutzername
			</label>
			<input id="firstName"
			       name="firstName"
			       type="firstName"
			       placeholder="firstName"
			       required value=<?php echo (isset($_POST['firstName']) ? $_POST['firstName'] : ''); //default Values?> >
		</div
		<br>
		<div class="input">
			<label for="lastName">
				Nutzername
			</label>
			<input id="lastName"
			       name="lastName"
			       type="lastName"
			       placeholder="lastName"
			       required value=<?php echo (isset($_POST['lastName']) ? $_POST['lastName'] : NULL); //default Values?> >
		</div
		<br>
		<div class="input">
			<label for="emailAddress">
				Nutzername
			</label>
			<input id="emailAddress"
			       name="emailAddress"
			       type="email"
			       placeholder="emailAddress"
			       required value=<?php echo (isset($_POST['emailAddress']) ? $_POST['emailAddress'] : NULL); //default Values?> >
		</div
		<br>
		<div class="input">
			<label for="phoneNumber">
				Nutzername
			</label>
			<input id="phoneNumber"
			       name="phoneNumber"
			       type="tel"
			       placeholder="phoneNumber"
			       value=<?php echo (isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : ''); //default Values?> >
		</div
		<br>
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
		<br>
		<div class="input">
			<label for="password">
				Passwort:
			</label>
			<input id="password"
			       name="password"
			       type="password"
			       placeholder="passowrd"
			       required value=<?php echo (isset($_POST['password']) ? $_POST['password'] : ''); //default Values?> >
		</div>
		<br>
		<div class="input submit">
			<input name="submit" type="submit" value="registrieren">
		</div>
	</form>

</div>