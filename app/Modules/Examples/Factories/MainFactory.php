<?php

namespace App\Modules\Examples\Repositories;

use App\Traits\CoreTrait;

class MainFactory
{
	use CoreTrait;

	public function getMessage() 
	{
		return "Hello World!!!";
	}

}
