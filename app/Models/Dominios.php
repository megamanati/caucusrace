<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dominios extends Model
{
    use HasFactory;

    protected $primaryKey = 'domainName';
    public $incrementing = false;
    protected $keyType = 'string';
}
