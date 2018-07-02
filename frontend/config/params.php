<?php
return [
    'adminEmail' => 'admin@example.com',

    'maxFileSize' => 1024 * 1024 * 2, //2 megabytes
    'storagePath' => '@frontend/web/uploads/',
    'storageUri' => '/uploads/',

    'profilePicture' => [
        'maxWidth' => 1024,
        'maxHeight' => 768,
    ],

    'feedPostLimit' => 200,
];
