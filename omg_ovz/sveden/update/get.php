<?php
require_once 'config.php';

$res['success'] = false;
$token = filterAccessToken($_GET['access_token']);
$parts = array();
foreach ($_GET['parts'] as $part) {
    $parts[] = filterPartName($part);
};
try {
    $data = getRemoteData($apiDomen . 'update/version?d=' . $domenName . '&access_token=' . $token);
    $connected = false;
    if ($data->success && $data->info->success) {
        $serverVersion = $data->info->version;
        // Создаем поток
        $zipData = getRemoteData($apiDomen . 'update/get?d=' . $domenName . '&access_token=' . $token
            . '&parts=' . json_encode($parts));
        if ($zipData->success && $zipData->info->success) {
            $opts = array(
                'http'=>array(
                    'method'=>"GET",
                    'header'=>"Accept-language: ru\r\n" .
                        "Accept-Encoding: zip, gzip"
                )
            );
            $zip = getRemoteData($zipData->info->link, $opts, false);
            if ($zip->success) {
                $filename = 'update-'.$serverVersion.'.zip';
                $dlHandler = fopen($filename, 'w');
                if ( !fwrite($dlHandler, $zip->info) ) {
                    $res['message'] = 'Не удается записать архив на диск';
                } else {
                    $res['success'] = true;
                    $res['version'] = $serverVersion;
                    $res['message'] = 'Архив загружен успешно.';
                }
                fclose($dlHandler);
            } else {
                $res['error'] = isset($zip->info->error) ? $zip->info->error : '';
                $res['message'] = 'Не удается скачать файл с обновлениями. ' . $zip->message;
            }
        } else {
            $res['error'] = isset($zipData->info->error) ? $zipData->info->error : '';
            $res['message'] = 'Не удается сформировать архив с обновлениями. '
                . ($zipData->success
                    ? $zipData->info->message
                    : $zipData->message);
        }
    } else {
        $res['error'] = isset($data->info->error) ? $data->info->error : '';
        $res['message'] = 'Не удается получить новую версию. '
            . ($data->success
                ? $data->info->message
                : $data->message);
    }
} catch (Exception $e) {
    $res['message'] = 'Ошибка при скачивании файла. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);