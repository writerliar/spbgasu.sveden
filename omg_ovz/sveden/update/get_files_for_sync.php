<?php
require_once 'config.php';

$res['success'] = false;
$token = filterAccessToken($_GET['access_token']);
try {
    $existingFiles = scandir('../files');
    if (is_array($existingFiles)) {
        $data = getRemoteData($apiDomen . 'update/remote_update/getMyListFilesForSync?&d=' . $domenName
            . '&access_token=' . $token);
        if ($data->success) {
            if ($data->info->success) {
                if ($files = $data->info->files) {
                    foreach ($existingFiles as $key => $file) {
                        if (!in_array($file, $files) && $file != '.' && $file != '..') {
                            unlink('../files/' . $file);
                        } else {
                            if (filesize('../files/' . $file) <= 0) {
                                unset($existingFiles[$key]);
                            }
                        }
                    }
                    $filesForSync = array();
                    foreach ($files as $file) {
                        if (!in_array($file, $existingFiles)) {
                            $filesForSync[] = $file;
                        }
                    }
                    $res['success'] = true;
                    $res['message'] = count($filesForSync) > 0
                        ? 'Получен список недостающих файлов.'
                        : 'Недостающих файлов не обнаружено.';
                    $res['files'] = $filesForSync;
                } else {
                    $res['success'] = true;
                    $res['files'] = array();
                    $res['Список всех файлов пуст. Синхронизация отменена.'];
                }
            } else {
                $res['error'] = isset($data->info->error) ? $data->info->error : '';
                $res['message'] = 'Ошибка в получении списка всех файлов.';
            }
        } else {
            $res['message'] = 'Не удалось соединиться с сервером.';
        }
    } else {
        $res['message'] = 'Не удалось просканировать существующие файлы.';
    }
} catch (Exception $e) {
    $res['message'] = 'Ошибка. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);

