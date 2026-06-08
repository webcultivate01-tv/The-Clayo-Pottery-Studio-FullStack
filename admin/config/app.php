<?php
return [
    'name'       => 'Calyo Studio Management',
    'env'        => 'local',
    'debug'      => true,
    'timezone'   => 'Asia/Kolkata',
    'base_path'  => '/clayo/admin',
    'session'    => [
        'name'      => 'CALYO_SID',
        'lifetime'  => 7200,
        'cookie_secure'   => false,
        'cookie_httponly' => true,
        'cookie_samesite' => 'Lax',
    ],
    'security'   => [
        'bcrypt_cost'      => 12,
        'csrf_token_name'  => '_csrf',
        'login_max_attempts' => 5,
        'login_lockout_seconds' => 900,
    ],
];
