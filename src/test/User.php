<?php

namespace fzed51\OAD\Test;

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
