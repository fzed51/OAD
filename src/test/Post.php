<?php

namespace fzed51\OAD\Test;

/**
 * Description of Post
 *
 * @author fabien.sanchez
 */
class Post extends \fzed51\OAD\Entity {

    protected $fields = [
        'id',
        'titre',
        'content',
        'id_owner'
    ];
    protected $fk = [
        'owner' => ['id_owner', 'Users']
    ];

}
