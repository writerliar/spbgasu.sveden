<?php
require_once 'config.php';

include('read_settings.php');

$res['success'] = false;
$token = filterAccessToken($_GET['access_token']);
try {
    $data = getRemoteData($apiDomen . 'update/remote_update/getCountFiles?&d=' . $domenName . '&access_token='
        . $token);
    if ($data->success) {
        if ($data->info->success) {
            if ($data->info->count > 0) {
                $res['success'] = true;
                $res['count'] = $data->info->count;
                $res['message'] = 'Количество файлов получено.';
            } else {
                $res['success'] = true;
                $res['count'] = 0;
                $res['message'] = 'Файлов для обновления не найдено.';
            }
        } else {
            $res['error'] = isset($data->info->error) ? $data->info->error : '';
            $res['message'] = 'Ошибка в получении количества файлов.';
        }
    } else {
        $res['message'] = 'Не удалось соединиться с сервером.';
    }
} catch (Exception $e) {
    $res['message'] = 'Ошибка при получении списка файлов. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);
