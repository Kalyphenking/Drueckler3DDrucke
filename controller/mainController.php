<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;

class MainController extends Controller
{

	public function logout() {
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);

		echo'<h1>logout</h1>';

		$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';


		if (isset($_POST['testing']) && $_POST['testing'] == 'destroy') {
			session_destroy();
		}

		if (!isset($_POST['testing']) || $_POST['testing'] == 'true') {
//
			if ($previousController == 'user') {
				$link = 'index.php?c=main&a=main';
			} else {
				$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
			}



			header("Location: $link ");
		}
	}

	public function login() {

		if (isset($_POST['submit'])) {

//			echo '<br> submit <br>';

			if(!empty($_POST['username'])
				&& !empty($_POST['password']))
			{
//				echo '<br> not empty <br>';

				$username = $_POST['username'];
				$password = $_POST['password'];

				$data = ContactData::find(['username'],[$username]);

//				echo json_encode($data);

				if (!empty($data) && password_verify($password, $data[0]["password"])) {
//					echo 'TRUE';
//					echo '<br>';
					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $username;

					$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
					$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';



//					echo $link . '<br>';
					if (!isset($_POST['testing']) || $_POST['testing'] == 'true') {

						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
						header("Location: $link ");
					}



				} else {
					echo 'FALSE';
				}

//				echo '<br>' . json_encode($data);
			}
		}
	}

	public function testLoginForm() {
		$this->login();
	}


	public function register() {

//		echo '<br><br> register <br><br>';

		if (isset($_POST['submit'])) {

//			echo '<br> submit <br>';

			if(!empty($_POST['firstName'])
				&& !empty($_POST['lastName'])
				&& !empty($_POST['emailAddress'])
				&& !empty($_POST['username'])
				&& !empty($_POST['password']))
			{

				$options = [
					'cost' => 12,
				];

				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : NULL;
				$emailAddress = $_POST['emailAddress'];
				$username = $_POST['username'];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT, $options);


				$keys = ['phoneNumber', 'emailAddress', 'username'];
				$values = [$phoneNumber, $emailAddress, $username];


				$data = ContactData::find($keys, $values);

				if (empty($data)) {
//					echo 'LÄUFT <br>';

					$contactData = new ContactData([
						'firstName'=>$firstName,
						'lastName'=>$lastName,
						'emailAddress'=>$emailAddress,
						'username'=>$username,
						'password'=>$password]);

					if (!empty($phoneNumber)) {
						$contactData->{'phoneNumber'} = $phoneNumber;
					}

//					echo json_encode($user->{'emailAddress'});
//					echo '<br>';


					$contactData->insert($error);

					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $contactData->{'username'};


					$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
					$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';


//					$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

//					header("Location: $link ");

					if (!isset($_POST['testing']) || $_POST['testing'] == 'true') {
						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

						header("Location: $link ");
					}


				} else {
//					echo 'LÄUFT NICHT <br>';
					echo json_encode($data);
					echo '<br>';
					// TODO: error, username already exists
				}
			} else {

			}
		}
	}
}