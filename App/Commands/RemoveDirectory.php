<?php

namespace App\Commands;

use App\Models\Directory;
use Cube\Console\Args;
use Cube\Console\Command;
use Cube\Utils\Console;

class RemoveDirectory extends Command
{
    public function getScope(): string
    {
        return 'fserver';
    }

    public function execute(Args $args): int
    {
        $path = $args->getValue('p', 'path');
        $uuid = $args->getValue('u', 'uuid');

        if (!($path || $uuid))  {
            Console::print(Console::withRedColor("-p (path) parameter is needed"));
            return 1;
        }

        if ($path)
            $directory = Directory::findWhere(['path' => $path]);

        if ($uuid)
            $directory = Directory::find($uuid);

        if (!$directory) {
            Console::print(
                Console::withBlueColor('Directory not found, nothing to destroy')
            );
            return 0;
        }
        $directory->destroy();

        Console::print(
            Console::withBlueColor("Directory unmounted, uuid = " . $directory->id())
        );
        return 0;
    }
}