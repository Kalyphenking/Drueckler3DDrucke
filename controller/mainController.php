<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;

//manages admin related functions

class MainController extends Controller
{

	public function logout($subAction) {
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);
		session_destroy();

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

	public function login($subAction) {

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

	public function register($subAction) {

		if ($subAction === 'guest') {
			$_SESSION['guest'] = true;
		}

		if (isset($_SESSION['guest'])) {
			$guest = 1;
		} else {
			$guest = 0;
		}

		if (isset($_POST['submit'])) {

			if(!empty($_POST['firstName'])
				&& !empty($_POST['lastName'])
				&& !empty($_POST['emailAddress'])
				&& !empty($_POST['username'])
				&& !empty($_POST['password']))
			{

				$firstName = $_POST['firstName'];
				$lastName = $_POST['lastName'];
				$phoneNumber = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : NULL;
				$emailAddress = $_POST['emailAddress'];
				$username = $_POST['username'];

				$options = [
					'cost' => 12,
				];
				$password = password_hash($_POST['password'],PASSWORD_BCRYPT, $options);


				$keys = ['phoneNumber', 'emailAddress', 'username'];
				$values = [$phoneNumber, $emailAddress, $username];


				$data = ContactData::find($keys, $values, 'or');


				if (empty($data)) {

					$contactData = new ContactData([
						'firstName'=>$firstName,
						'lastName'=>$lastName,
						'emailAddress'=>$emailAddress,
						'username'=>$username,
						'password'=>$password]);

					if (!empty($phoneNumber)) {
						$contactData->{'phoneNumber'} = $phoneNumber;
					}

					//inserts contactData in database and inserts newst ContactData_id in Customer
					//to reduce database request, this will processed in one request

					$contactData->insert($error, ['INSERT INTO Customer (guest, ContactData_id)	VALUES ('.$guest.', LAST_INSERT_ID());']);

					$_SESSION['loggedIn'] = true;
					$_SESSION['username'] = $contactData->{'username'};


					$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
					$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

					if (!isset($_POST['testing']) || $_POST['testing'] == 'true') {
						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

						header("Location: $link ");
					}


				} else {
					echo json_encode($data);
					echo '<br>';
					// TODO: error, username already exists
				}
			} else {

			}
		}
	}
}