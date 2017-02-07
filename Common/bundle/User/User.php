<?php

class User extends Display
{
	public function login()
	{
		if (!empty($_POST['email']) && !empty($_POST['password'])) {

			$login = $_POST['email'];
			$password = $_POST['password'];

			$user = $this->auth($login, $password);

			if ($user) {
				$this->controller->setSession('auth', md5($user['id']));
				$this->controller->setSession('user_id', $user['id']);
				$this->controller->redirect('/');
			}
		}

		echo $this->fetch('login.phtml');

	}

	public function logout()
	{
		$this->controller->doClearSession();
		$this->controller->redirect('/');
	}

	public function getUserIDByToken($token)
	{
		$search = array(
			'access_token' => $token
		);

		$user = $this->object->get($search);

		return $user['id'];
	}
	
	public function getUserByID($id)
	{
		$search = array(
			'id' => $id
		);

		$user = $this->object->get($search);

		return $user;
	}
	
	public function auth($login, $password)
	{
		$search = array(
			'email'    => $login,
			'password' => md5($password) // FIX ME
		);

		$user = $this->object->get($search);
		if (!$user) {
			return false;
			//throw new Exception('Auturization Error. Not Found User');
		}
		
		return $user;
	}

	public function setTokenByUser($idUser, $token)
	{
		$search = array(
			'id' => $idUser
		);
		$values = array(
			'access_token' => $token
		);

		return $this->object->updateUser($search, $values);
	}

	public function getCurrentUserToken()
	{
		$idUser = $this->controller->getCurrentUserID();

		$userValuesObject = $this->bundle->User->loadRow($idUser);

		return $userValuesObject->getAccessToken();
	}

	public function get($search)
	{
		return $this->object->get($search);
	}

	public function loadRow($search)
	{
		$data = $this->get($search);

		return new UserValuesObject($data);
	}

	public function load()
	{

	}
}