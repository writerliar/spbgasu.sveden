<?php

    require_once 'config.php';

    $res['success'] = false;
    $version = filterVersion($_GET['version']);
    $fileName = 'update-' . $version . '.zip';
    $parts = array();
    foreach ($_GET['parts'] as $part) {
        $parts[] = filterPartName($part);
    };

    removeDirectory('../../edustandarts');
    removeDirectory('../../Abitur');

    if (file_exists($fileName)) {
        try {
            if (in_array('abitur', $parts)) {
                if ($filelist = glob('../../abitur/*.html')) {
                    foreach ($filelist as $file) {
                        unlink($file);
                    }
                }
            }
            $res = unpackZip($fileName, "./../../");
            if ($res['success']) {
                $res['message'] = 'Скрипты обновления успешно обновлены';
            }
        } catch (Exception $e) {
            $res['message'] = 'Ошибка при распоковке скриптов обновления' . $e->getMessage();
        }
    } else {
        $res['message'] = 'Не найден файл ' . $fileName . ' для распаковки';
    }
    loadHeaders();
    echo json_encode($res);

