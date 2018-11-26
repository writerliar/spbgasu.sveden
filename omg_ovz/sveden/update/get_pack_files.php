<?php

require_once 'config.php';
include('read_settings.php');

$res['success'] = false;
$token = filterAccessToken($_GET['access_token']);
$startFiles = filterInt($_GET['startFiles']);
$filesForPart = filterInt($_GET['filesForPart']);
try {
    $data = getRemoteData($apiDomen . 'update/remote_update/createPackFiles?&d=' . $domenName . '&start_files='
        . $startFiles . '&files_for_part=' . $filesForPart . '&access_token=' . $token);
    include('pack_files.php');
} catch (Exception $e) {
    $res['message'] = 'Ошибка при получении списка файлов. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);