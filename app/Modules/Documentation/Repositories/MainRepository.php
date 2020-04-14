<?php

namespace App\Modules\Documentation\Repositories;

use App\Traits\CoreTrait;

class MainRepository 
{
	use CoreTrait;

	public function getMessage() 
	{
		return "Hello World!!!";
	}

}
