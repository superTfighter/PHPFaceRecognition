<?php

namespace App\Modules\Documentation\Repositories;

use App\Traits\CoreTrait;

class MainFactory
{
	use CoreTrait;

	public function getMessage() 
	{
		return "Hello World!!!";
	}

}
