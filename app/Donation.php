<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
	/** 
	* Not a lot happens in this file. 
	* There are no relationships and 
	* the only field we care about 
	* guarding is the id. Anything more
	* would overcomplicate the app 
	* and 
	**/
    protected $guarded = ['id'];
}
