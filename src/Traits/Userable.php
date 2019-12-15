<?php

namespace Majebry\LaravelUserable\Traits;

trait Userable
{
    /**
     * get the actual User model
     */
    public function userable()
    {
        return $this->morphTo();
    }
}