<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dominios extends Model
{
    use HasFactory;

    protected $primaryKey = 'domainName';
    protected $keyType = 'string';
    public $incrementing = false;
}
