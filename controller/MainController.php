<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;

class MainController extends Controller
{



	public function login() {

		echo '<br><br> login <br><br>';

		if (isset($_POST['submit'])) {

//			echo '<br> submit <br>';

			if(!empty($_POST['username'])
				&& !empty($_POST['password']))
			{
				echo '<br> not empty <br>';

				$username = $_POST['username'];
				$password = $_POST['password'];

				$data = ContactData::find('username',$username);

//				echo json_encode($data[0]['password']);

				if (password_verify($password, $data[0]["password"])) {
					echo 'TRUE';
					echo '<br>';
					$_SESSION['loggedIn'] = true;

					$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
					$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

					echo 'prevController: ' . $previousController;
					echo '<br>';
					echo 'prevAction: ' . $previousAction;
					echo '<br>';

					$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

					header("Location: $link ");

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
				$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : '';
				$emailAddress = $_POST['emailAddress'];
				$username = $_POST['username'];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT, $options);

				$data = ContactData::find('username',$username);

				if (empty($data)) {
					$user = new ContactData([
						'firstName'=>$firstName,
						'lastName'=>$lastName,
						'emailAddress'=>$emailAddress,
						'username'=>$username,
						'password'=>$password]);

					if (!empty($phoneNumber)) {
						$user->{'phoneNumber'} = $phoneNumber;
					}

					echo json_encode($user->{'emailAddress'});

					$user->insert($error);


				} else {
					echo 'schon voll';
					// TODO: error, username already exists
				}
			} else {

			}
		}
	}
}