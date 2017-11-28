<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Codes extends \Eloquent {
    protected $table = 'user_activation_code';
}
