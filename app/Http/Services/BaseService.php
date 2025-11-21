<?php

namespace App\Http\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
abstract class BaseService
{
    public abstract function getModel(): string;



}
