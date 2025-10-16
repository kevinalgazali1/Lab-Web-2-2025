<?php
$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],
    [
        'email' => 'jaemin@gmail.com',
        'username' => 'na_jaemin',
        'name' => 'Na Jaemin',
        'password' => password_hash('jaemin123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Kedokteran',
        'batch' => '2023',
    ],
    [
        'email' => 'carmen@gmail.com',
        'username' => 'carmenita12',
        'name' => 'Nyoman Ayu Carmenita',
        'password' => password_hash('memen123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Seni & Pertunjukan',
        'batch' => '2022',
    ],
    [
        'email' => 'marklee@gmail.com',
        'username' => 'onyourm_ark',
        'name' => 'Lee Min-Hyung',
        'password' => password_hash('leemark123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Ilmu Komputer',
        'batch' => '2021',
    ],
    [
        'email' => 'jiwoo@gmail.com',
        'username' => 'jw.h2h',
        'name' => 'Choi Ji-woo',
        'password' => password_hash('jiwoo123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Hukum',
        'batch' => '2024',
    ],
];
?>