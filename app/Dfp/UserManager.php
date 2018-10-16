<?php

namespace App\Dfp;

require __DIR__.'/../../vendor/autoload.php';

use Google\AdsApi\Dfp\v201802\UserService;
use Google\AdsApi\Dfp\v201802\User;
use Google\AdsApi\Dfp\Util\v201802\StatementBuilder;

class UserManager extends DfpManager
{
	protected $user;

	public function getCurrentUser()
	{
		$userService = $this->dfpServices->get($this->session, UserService::class);

		$user = $userService->getCurrentUser();
		$output = [
			'userId' => $user->getId(),
			'userName' => $user->getName(),
			'userMail' => $user->getEmail(),
			'userRole' => $user->getRoleName(),
		];
		$this->user = $output;

		return $output;
	}

	public function createUser()
	{
		$userService = $this->dfpServices->get($this->session, UserService::class);
		$user = new User();
		$user->setName('Gabriel');
		$user->setEmail('gabriel@insideall.com');
		//$user->setName($userName);
		$user->setRoleId('-1');
		// Create the users on the server.
		$results = $userService->createUsers([$user]);
		// Print out some information for each created user.
		foreach ($results as $i => $user) {
			printf(
				"%d) User with ID %d and name '%s' was created.\n",
				$i,
				$user->getId(),
				$user->getName()
			);
		}
	}

	public function getUserId()
	{
		$userArray = $this->getCurrentUser();

		return $userArray['userId'];
	}

	public function getAllUsers()
	{
		$userService = $this->dfpServices->get($this->session, UserService::class);
		$statementBuilder = (new StatementBuilder())->orderBy('id ASC');
		$data = $userService->getUsersByStatement(
			$statementBuilder->toStatement()
		);
		if (null !== $data->getResults()) {
			$totalResultSetSize = $data->getTotalResultSetSize();
			$i = $data->getStartIndex();
			foreach ($data->getResults() as $user) {
				printf(
					"%d) User with ID %d and name '%s' was found.\n",
					$i++,
					$user->getId(),
					$user->getName()
				);
			}
		}
	}
}
