<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$name      = trim($_POST['name'] ?? '');
$member_no = trim($_POST['member_no'] ?? '');
$address   = trim($_POST['address'] ?? '');
$phone     = trim($_POST['phone'] ?? '');

$errors = [];

if ($name === '') {
    $errors[] = "Name is required.";
}
if ($member_no === '') {
    $errors[] = "Member No. is required.";
}

if ($member_no !== '' && !preg_match('/^[A-Za-z][A-Za-z0-9]*$/', $member_no)) {
    $errors[] = "Nomor anggota harus diawali huruf, contoh: A001.";
}

if ($member_no !== '' && isset($_SESSION['members'])) {
    foreach ($_SESSION['members'] as $existing) {
        if ($existing['member_no'] === $member_no) {
            $errors[] = "Nomor anggota $member_no sudah dipakai, gunakan nomor lain.";
            break;
        }
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = [
        'type'    => 'error',
        'message' => implode(' ', $errors)
    ];
    header('Location: add.php');
    exit;
}

if (!isset($_SESSION['members'])) {
    $_SESSION['members'] = [];
}

$_SESSION['members'][] = [
    'name'      => $name,
    'member_no' => $member_no,
    'address'   => $address,
    'phone'     => $phone,
];

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Member added successfully.'];
header('Location: list.php');
exit;