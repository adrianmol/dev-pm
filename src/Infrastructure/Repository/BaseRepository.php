<?php

namespace DevPM\Infrastructure\Repository;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    abstract static protected function getModel(): Model;
}
