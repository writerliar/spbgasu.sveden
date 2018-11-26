<?php

require_once 'config.php';

$res['success'] = false;
$token = filterAccessToken($_GET['access_token']);
try {
    $data = getRemoteData($apiDomen . 'update/complete?&d=' . $domenName . '&access_token=' . $token);
    if ($data->success && $data->info->success) {
        $res['success'] = true;
        $res['message'] = 'Обновление до версии <b>' . $data->info->version . '</b> прошло успешно.';
        $res['version'] = $data->info->version;

    } else {
        $res['error'] = isset($data->info->error) ? $data->info->error : '';
        $res['message'] = 'Не удалось отправить запрос об завершении обновления. '
            . ($data->success
                ? $data->info->message
                : $data->message);
    }
} catch (Exception $e) {
    $res['message'] = 'Ошибка при завершении обновления. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);