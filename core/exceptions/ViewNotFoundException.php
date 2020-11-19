<?php

namespace core\exceptions;

class ViewNotFoundException extends \Exception
{
    public function __construct()
    {
         return \Exception::__construct(" Exception: View Not Found ");
    }

}