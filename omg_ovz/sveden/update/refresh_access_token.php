<?php
require_once 'config.php';

$res['success'] = false;
$refreshToken = filterAccessToken($_POST['refresh_token']);
$domen = filterUrl($_POST['domen']);
try {
    $data = getRemoteData($apiDomen . 'oauth2/RefreshToken', null, true, array(
        'refresh_token' => $refreshToken,
        'client_id' => $clientId,
        'client_secret' => $clientSecret,
        'grant_type' => 'refresh_token',
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
    $res['message'] = 'Ошибка при обновлении ключа. ' . $e->getMessage();
}
loadHeaders();
echo json_encode($res);

