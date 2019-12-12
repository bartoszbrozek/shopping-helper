<?php

namespace App\Service;

use App\Entity\User;

abstract class AbstractEntityService
{
    /**
     * Authenticated user
     *
     * @var User
     */
    protected $user;

    public function setUser(?User $user): void
    {
        $this->user = $user;
    }
}
