<?php

namespace DDDDD\controller;

use DDDDD\core\Controller;
use DDDDD\model\ContactData;
use DDDDD\model\Employee;
use DDDDD\model\Order;

//manages admin related functions

class MainController extends Controller
{

	public function logout($subAction) {
//		unset($_SESSION['loggedIn']);
//		unset($_SESSION['username']);
//		unset($_SESSION['employeeName']);
//		unset($_SESSION['customerName']);
//		unset($_SESSION['admin']);
		session_destroy();

		echo'<h1>logout</h1>';

		$previousController = isset($_SESSION['previousController']) && $_SESSION['previousController'] != $this->controller ? $_SESSION['previousController'] : 'main';
		$previousAction = isset($_SESSION['previousAction']) && $_SESSION['previousAction'] != $this->action ? $_SESSION['previousAction'] : 'main';


		if (($previousController == 'user') || ($previousController == 'admin')) {
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

					if (!empty($data) && password_verify($password, $data[0]["password"])) {

						$employee = Employee::find(['ContactData_id'], [$data[0]['id']]);

						if (!empty($employee)) {
							if ($employee[0]['admin'] == true) {


								$_SESSION['admin'] = true;
							}
							$_SESSION['employeeName'] = $username;
						} else {
							$_SESSION['customerName'] = $username;
						}
						$_SESSION['username'] = $username;
						$_SESSION['loggedIn'] = true;

						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;
						header("Location: $link ");

					} else {
						echo 'FALSE';
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
							'password'=>$password]);

						if (!empty($phoneNumber)) {
							$contactData->{'phoneNumber'} = $phoneNumber;
						}

						$contactData->insert($error, ['INSERT INTO Customer (guest, ContactData_id)	VALUES ('.$guest.', LAST_INSERT_ID());']);

						$_SESSION['loggedIn'] = true;
						$_SESSION['customerName'] = $contactData->{'username'};
						$_SESSION['username'] = $contactData->{'username'};

						$link = 'index.php?c=' . $previousController . '&a=' . $previousAction;

						header("Location: $link ");

					} else {
						echo json_encode($data);
						echo '<br>';
						// TODO: error, username already exists
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