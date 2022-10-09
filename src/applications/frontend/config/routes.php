<?php

declare(strict_types = 1);

return [
    '/' => 'site/index',
    '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
];
