<?php

namespace RyanChandler\Console;

class Kernel
{
    public static $commands = [
        Commands\FetchWebmentionsCommand::class,
    ];
}