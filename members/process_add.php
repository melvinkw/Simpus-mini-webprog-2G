<?php
    session_start();
require __DIR__ . '/../includes/connection.php';

$name = trim($_POST['name'] ?? '');
$memberId = trim($_POST['member_id'] ?? '');
$address = trim($_POST['address'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$errors = [];
if ($name === '') {
    $errors[] = "Name is required.";
}
if ($memberId === '') {
    $errors[] = "Member No. is required.";
}

if ($memberId !== '' && !preg_match('/^[A-Za-z][A-Za-z0-9]*$/', $memberId)) {
    $errors[] = "Nomor anggota harus diawali huruf, contoh: A001.";
}

if ($memberId !== '' && isset($_SESSION['members'])) {
    foreach ($_SESSION['members'] as $existing) {
        if ($existing['memberId'] === $memberId) {
            $errors[] = "Nomor anggota $memberId sudah dipakai, gunakan nomor lain.";
            break;
        }
    }
}

if (!empty($errors)) {
    $_SESSION['flash'] = ['type' => 'error', 'message' => implode(' ', $errors)];
    header('Location: add.php');
    exit;
}

$stmt = $pdo->prepare(
    "INSERT INTO members (name, member_id, address, phone)
     VALUES (:name, :member_id, :address, :phone)
     RETURNING id"
);
$stmt->execute([
    'name' => $name,
    'member_id' => $memberId,
    'address' => $address,
    'phone' => $phone,
]);

$_SESSION['flash'] = ['type' => 'success', 'message' => 'Member added successfully.'];
header('Location: list.php');
exit;