<?php

namespace App\Repositories;

use App\Traits\CoreTrait;

class HomeRepository 
{
	use CoreTrait;

	public function getMessage() 
	{
		return "Hello World!!!";
	}

}