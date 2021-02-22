<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;
use DDDDD\model\Employee;
use DDDDD\model\Order;

//manages management related functions

class MainController extends Controller
{

	protected $errors = null;

	public function logout($subAction) {
		session_destroy();

		echo'<h1>logout</h1>';

		$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';


		if (($previousController == 'user') || ($previousController == 'management')) {
			$link = 'index.php?c=main&a=main';
		} else {
			$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
		}

		header("Location: $link ");
	}

	public function login($subAction) {

		$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';

		if (!isset($_SESSION['loggedIn'])) {
			if (isset($_POST['submit'])) {

				if(!empty($_POST['username'])
					&& !empty($_POST['password']))
				{

					$username = $_POST['username'];
					$password = $_POST['password'];

					$data = ContactData::find(['username'],[$username]);

//					echo json_encode($_POST['password']);

					if (!empty($data) && password_verify($password, $data[0]["password"])) {

						$employee = Employee::find(['ContactData_id'], [$data[0]['id']]);

						if (!empty($employee)) {
							if ($employee[0]['admin'] == true) {

								$_SESSION['admin'] = true;
							} else {
								$_SESSION['employee'] = true;
							}
						} else {
							$_SESSION['customerName'] = $username;
						}
						$_SESSION['username'] = $username;
						$_SESSION['loggedIn'] = true;

						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
						header("Location: $link ");

					} else {
						$_SESSION['error'] = 'Fehler: Username oder Passwort falsch!';
					}

				}
			}
		} else {
			$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
			header("Location: $link ");
		}


	}

	public function register($subAction) {

		$previousController = isset($_SESSION['previousController']) ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) ? $_SESSION['previousAction'] : 'main';

		if (!isset($_SESSION['loggedIn'])) {
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
							'password'=>$password
						]);

						if (!empty($phoneNumber)) {
							$contactData->{'phoneNumber'} = $phoneNumber;
						}

						$contactData->validate($this->errors);

						if (empty($this->errors)) {
							$contactData->insert($error, ['INSERT INTO Customer (guest, ContactData_id)	VALUES ('.$guest.', LAST_INSERT_ID());']);

							$_SESSION['loggedIn'] = true;
							$_SESSION['customerName'] = $contactData->{'username'};
							$_SESSION['username'] = $contactData->{'username'};

							$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

							header("Location: $link ");
						} else {
							$_SESSION['error'] = '';
							foreach ($this->errors as $item) {
//								echo json_encode($this->errors);
								$_SESSION['error'] .= $item[0];
								$_SESSION['error'] .= '<br>';
							}
						}



					} else {
						$_SESSION['error'] = 'Fehler: Username oder Emailadresse schon in Benutzung!';
						if (!empty($phoneNumber)) {
							$_SESSION['error'] = 'Fehler: Username, Emailadresse oder Telefonnummer schon in Benutzung!';
						}
					}
				} else {

				}
			}
		} else {
			$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

			header("Location: $link ");
		}


	}

}