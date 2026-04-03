<?php

namespace App\Controllers\Requests;

use Cube\Web\Http\Request;
use Cube\Web\Http\Rules\Param;
use Cube\Web\Http\Rules\Rule;

class ShowDirectoryRequest extends Request
{
    public function getRules(): array|Rule
    {
        return [
            'password' => Param::string(false, true)
        ];
    }
}