<?php

namespace App\Repository;

abstract class BaseRepository
{
    const CACHE_KEY = 'base_repository_MODEL_cache';
    protected array $cacheMethod;

    public function __construct()
    {
        foreach ($this->cacheMethod as $k => $v) {

        }
    }
}
