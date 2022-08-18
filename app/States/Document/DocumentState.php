<?php

namespace App\States\Document;

use \Spatie\ModelStates\Exceptions\InvalidConfig;
use \Spatie\ModelStates\State;
use \Spatie\ModelStates\StateConfig;

abstract class DocumentState extends State
{
    /**
     * @return StateConfig
     * @throws InvalidConfig
     */
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Draft::class);
    }
}
