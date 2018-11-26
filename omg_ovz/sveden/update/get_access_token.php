<?php
require_once 'config.php';

$res['success'] = false;
$code = filterAccessToken($_POST['code']);
$domen = filterUrl($_POST['domen']);
try {
    $data = getRemoteData($apiDomen . 'oauth2/authorize/token', null, true, array(
        'code' => $code,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'redirect_uri' => $domen . '/sveden/update/index.php',
        'grant_type' => 'authorization_code',
        'scope' => 'userinfo',
    ));
    if ($data->success) {
        if (isset($data->info->access_token)) {
            $res['access_token'] = $data->info->access_token;
            $res['refresh_token'] = $data->info->refresh_token;
            $res['success'] = true;
        } else {
            $res['message'] = 'Ошибка ' . $data->info->error_description;
        }
    } else {
        $res['message'] = 'Не удалось соединиться с сервером.';
    }

} catch (Exception $e) {
    $res['message'] = 'Ошибка при получении ключа. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);

