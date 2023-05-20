<?php

require_once __DIR__ . '/../../src/services/apiController.php';
require_once __DIR__ . '/../../src/services/user/authService.php';
require_once __DIR__ . '/../../src/services/file/fileService.php';
require_once __DIR__ . '/../../src/db/Database.php';

checkRequestType();
$user = canUserAccess('Rukovodilac');

$id = getDataFromPostRequest('id');

$db = Database::getConnection();
try {
    $db->beginTransaction();

    $statement = $db->prepare("DELETE FROM file WHERE taskId=?");
    if ($statement->execute([$id])) {
        deleteFolder(__DIR__ . '/../../uploads/task-' . $id);
    }

    $statement = $db->prepare("DELETE FROM task WHERE id=?");
    $statement->execute([$id]);

    $db->commit();
} catch (Exception $exception) {
    $db->rollBack();
    badRequest('Task not deleted successfully');
}
sendResponse(['message' => 'Task deleted successfully']);

