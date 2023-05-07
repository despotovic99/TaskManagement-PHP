<?php

require_once __DIR__ . '/../src/services/util.php';
require_once __DIR__ . '/../src/services/registrationService.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    response('Bad request', 400, false, 'Route not found.');
}

if (empty($_GET['token'])) {
    response('Bad request', 400, false, 'Token missing.');
}

try {
    $token = htmlspecialchars(trim($_GET['token']));
    activateAccount($token);

    response('Account activated');
} catch (Exception $e) {
    response('Bad request', 400, false, $e->getMessage());
}
