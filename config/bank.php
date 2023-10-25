<?php

use Costa\Entity\ValueObject\Uuid;

return [
    'id' => new Uuid(env('BANK_ID')),
];
