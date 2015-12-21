<?php

namespace Test;

/**
 * Description of User
 *
 * @author fabien.sanchez
 */
class User extends \fzed51\OAD\Entity {

    protected $fields = [
        'id',
        'login',
        'mdp',
        'email'
    ];

}
