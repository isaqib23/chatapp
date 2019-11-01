<?php
/**
 * @see https://github.com/Edujugon/PushNotification
 */

return [
    'gcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'AIzaSyB3diFuxMT9Yk2cEJGRMpz_t6h_shNlh0M',
    ],
    'fcm' => [
        'priority' => 'normal',
        'dry_run' => false,
        'apiKey' => 'AAAA9dwYnNI:APA91bFnyCAXJLe8R0pSlXES-hLwQiZk0Mu4DOkJPd3fsMxx-78gvWmj_rwgLZtYqpgSg_m7xHms0GqyFyHa9WkQdjO-LlRAR6td6Oyaum9Ma7WbZ_tbSh1sD5Nbdy-Hh54Zv7Rx5nui',
    ],
    'apn' => [
        'certificate' => __DIR__ . '/iosCertificates/apns-dev-cert.pem',
        'passPhrase' => 'secret', //Optional
        'passFile' => __DIR__ . '/iosCertificates/yourKey.pem', //Optional
        'dry_run' => true,
    ],
];
