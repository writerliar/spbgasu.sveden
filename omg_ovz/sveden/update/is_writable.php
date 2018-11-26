<?php

function isWritableR($dir)
{
    $message = '';
    if (is_dir($dir)) {
        if (is_writable($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    $message .= isWritableR($dir . "/" . $object);
                }
            }
        } else {
            $message .= 'Отсутствуют права на запись: "' . $dir . '"<br>';
        }
    } else if (!is_writable($dir)) {
        $message .= 'Отсутствуют права на запись: "' . $dir . '"<br>';
    }
    return $message;
}

$messageSveden = '';
if (file_exists('../../sveden')) {
    $messageSveden = isWritableR('../../sveden');
}
$messageAbitur = '';
if (file_exists('../../abitur')) {
    $messageAbitur = isWritableR('../../abitur');
}

if ($messageSveden || $messageAbitur) {
    echo '<p class="alert alert-danger">' . $messageSveden . $messageAbitur . '</p>';
}