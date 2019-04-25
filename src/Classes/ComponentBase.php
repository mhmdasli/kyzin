<?php


namespace MhmdAsli\Kyzin\Classes;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ComponentBase extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
