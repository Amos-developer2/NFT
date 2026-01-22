<?php

return [
    'enabled' => true,
    'view'    => 'google2fa::index',
    'route'   => '2fa',
    'middleware' => ['web', 'auth'],
    'window' => 4,
    'forbid_old_passwords' => false,
    'otp_input' => 'one_time_password',
    'otp_secret_column' => 'google2fa_secret',
    'otp_enabled_column' => 'two_factor_enabled',
    'qrcode_service' => 'BaconQrCode',
];
