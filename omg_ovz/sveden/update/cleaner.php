<?php

require_once 'config.php';

$res['message'] = 'Ошибка удаления временных файлов.';
$res['success'] = true;

if ($filelist = glob('../update/*.zip')) {
    foreach ($filelist as $file) {
        if (!unlink($file)) {
            $res['success'] = false;
        }
    }
    $res['message'] = 'Временные файлы успешно удалены.';
}

loadHeaders();

echo json_encode($res);