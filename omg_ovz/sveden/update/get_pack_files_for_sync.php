<?php
require_once 'config.php';

$res['success'] = false;
$files = $_POST['files'];
foreach ($files as &$file) {
    $file = filterFileName($file);
}
$files = serialize($files);
$token = filterAccessToken($_POST['access_token']);
try {
    $data = getRemoteData($apiDomen . 'update/remote_update/getPackFilesForSync', null, true,
        array(
            'd' => $domenName,
            'access_token' => $token,
            'files' => $files,
        )
    );
    include('pack_files.php');
} catch (Exception $e) {
    $res['message'] = 'Ошибка при получении списка файлов. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);