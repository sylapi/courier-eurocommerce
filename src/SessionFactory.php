<?php

declare(strict_types=1);

namespace Sylapi\Courier\Eurocommerce;

use Sylapi\Courier\Eurocommerce\Entities\Credentials;

class  SessionFactory
{
    private $sessions = [];

    public function session(Credentials $credentials): Session
    {
        $key = sha1($credentials->getLogin().':'.$credentials->getPassword());

        return (isset($this->sessions[$key])) ? $this->sessions[$key] : ($this->sessions[$key] = new Session($credentials));
    }
}
