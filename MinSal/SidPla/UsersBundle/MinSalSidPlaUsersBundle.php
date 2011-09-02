<?php

namespace MinSal\SidPla\UsersBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MinSalSidPlaUsersBundle extends Bundle
{
     public function getParent()
    {
        return 'FOSUserBundle';
    }
}
