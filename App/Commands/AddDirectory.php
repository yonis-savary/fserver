<?php

namespace App\Commands;

use App\Models\Directory;
use Cube\Console\Args;
use Cube\Console\Command;
use Cube\Utils\Console;

class AddDirectory extends Command
{
    public function getScope(): string
    {
        return 'fserver';
    }

    public function execute(Args $args): int
    {
        $path = $args->getValue('p', 'path');
        $password = $args->getValue('P', 'password');

        if (!$path)  {
            Console::print(Console::withRedColor("-p (path) parameter is needed"));
            return 1;
        }

        $directory = new Directory(['path' => $path]);
        if ($password) {
            $directory->password_hash = password_hash($password, PASSWORD_BCRYPT, ['cost' => 4]);
        }

        $directory->save();

        Console::print(
            Console::withBlueColor("Directory mounted, uuid = " . $directory->id())
        );
        return 0;
    }
}