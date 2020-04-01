<?php

namespace App\Modules\Examples\Repositories;

use App\Traits\CoreTrait;

class MainRepository 
{
	use CoreTrait;

	public function getMessage() 
	{
		return "Hello World!!!";
	}

}
