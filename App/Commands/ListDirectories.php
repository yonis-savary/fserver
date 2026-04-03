<?php

namespace App\Commands;

use App\Models\Directory;
use Cube\Console\Args;
use Cube\Console\Command;
use Cube\Utils\Console;

class ListDirectories extends Command
{
    public function getScope(): string
    {
        return 'fserver';
    }

    public function execute(Args $args): int
    {
        $directories = Directory::select()->fetchBunch();

        Console::table(
            $directories->map(
                fn(Directory $dir) => [
                    $dir->uuid,
                    $dir->path,
                    $dir->password_hash ? 'Yes': 'No'
                ]
            )
            ->toArray(),
            ['uuid', 'path', 'secured']
        );
        return 0;
    }
}