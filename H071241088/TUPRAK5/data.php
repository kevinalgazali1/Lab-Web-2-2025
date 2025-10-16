<?php

$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],
    [
        'email' => 'jabbar@gmail.com',
        'username' => 'jab_aja',
        'name' => 'Abd Jabbar Fanshurna Musra',
        'password' => password_hash('jab123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'MIPA',
        'batch' => '2023',
    ],
    [
        'email' => 'ervin@gmail.com',
        'username' => 'ervin',
        'name' => 'Muhammad Ervin',
        'password' => password_hash('ervin123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Hukum',
        'batch' => '2023',
    ],
    [
        'email' => 'yusra@gmail.com',
        'username' => 'yusra59',
        'name' => 'Yusra Airlangga',
        'password' => password_hash('yusra123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Keperawatan',
        'batch' => '2021',
    ],
    [
        'email' => 'muslih@gmail.com',
        'username' => 'muslih23',
        'name' => 'Muslih',
        'password' => password_hash('muslih123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020',
    ],
];
?>