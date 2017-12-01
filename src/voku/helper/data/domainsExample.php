<?php

static $data = [
    'test.de',
    'test.com',
    'test.net',
    'test.org',
    'example.de',
    'example.com',
    'example.net',
    'example.org',
];

$result =& $data;
unset($data);

return $result;
