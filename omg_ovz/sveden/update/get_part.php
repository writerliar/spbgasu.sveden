<?php
    require_once 'config.php';

    $res['success'] = false;
    $token = filterAccessToken($_GET['access_token']);
    $part = filterPartName($_GET['part']);
    try {
        // Создаем поток
        $zipData = getRemoteData($apiDomen . 'update/get_part?&d=' . $domenName . '&access_token=' . $token
            . '&part=' . $part);
        if ($zipData->success && $zipData->info->success) {
            $opts = array(
                'http' => array(
                    'method' => "GET",
                    'header' => "Accept-language: ru\r\n" .
                        "Accept-Encoding: zip, gzip"
                )
            );
            $zip = getRemoteData($zipData->info->link, $opts, false);
            if ($zip->success) {
                $filename = $part . '.zip';
                $dlHandler = fopen($filename, 'w');
                if ( !fwrite($dlHandler, $zip->info) ) {
                    $res['message'] = 'Не удается записать архив на диск';
                } else {
                    if ($part == 'abitur') {
                        $unpackPath = '../../';
                    } else {
                        $unpackPath = '../';
                    }
                    $resUnpack = unpackZip($filename, $unpackPath);
                    if ($resUnpack['success']) {
                        $res['success'] = true;
                        $res['message'] = 'Раздел ' . $part . ' успешно обновлен.';
                    } else {
                        $res['message'] = 'Не удалось распаковать архив раздела ' . $part . '.';
                    }
                }
                fclose($dlHandler);
            } else {
                $res['message'] = 'Не удается скачать файл с обновлениями раздела ' . $part . '. ' . $zip->message;
            }
        } else {
            $res['error'] = isset($zipData->info->error) ? $zipData->info->error : '';
            $res['message'] = 'Не удается сформировать архив с обновлениями раздела ' . $part . '. '
            . ($zipData->success
                ? $zipData->info->message
                : $zipData->message);
        }
    } catch (Exception $e) {
        $res['message'] = 'Ошибка при скачивании файла. ' . $e->getMessage();
    }
    loadHeaders();
    echo json_encode($res);

