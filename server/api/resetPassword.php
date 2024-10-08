<?php

require_once __DIR__ . '/../src/services/apiController.php';
require_once __DIR__ . '/../src/services/user/userService.php';
require_once __DIR__ . '/../src/db/Database.php';

checkRequestType();

$password = getDataFromPostRequest('password', false);
$confirmedPassword = getDataFromPostRequest('confirmedPassword', false);
$token = getDataFromPostRequest('token', false);

if ($password !== $confirmedPassword) {
    badRequest('Passwords don\'t match!');
}
$password = hash('md5', $password);
$db = Database::getConnection();

$result = $db->query("SELECT * FROM pendingEmail WHERE token='$token' AND expiresAt IS NOT NULL");
if (!$result || !($user = $result->fetch(PDO::FETCH_ASSOC))) {
    badRequest('Token is not found.');
}

if ((new DateTime($user['expiresAt']))->getTimestamp() < (new DateTime())->getTimestamp()) {
    badRequest('Your token is expired.');
}

try {
    $db->beginTransaction();
    $db->query("UPDATE user SET password='$password' WHERE email='{$user['email']}'");
    $db->query("DELETE FROM pendingEmail WHERE id='{$user['id']}'");
    $db->commit();
} catch (Exception $exception) {
    $db->rollBack();
    badRequest('Error occured, password not changed.');
}

sendResponse(['message' => 'Password changed successfully']);

