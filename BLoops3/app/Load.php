<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class Load extends \Eloquent {
    protected $table = 'db_load_queue';
}
