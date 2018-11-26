<?php
require_once 'config.php';

header('Content-Type: text/html; charset=UTF-8');
$currentVersion = file_get_contents('cur_version.php');

$assetsDir = '//' . $domenName . '/sveden/assets/';
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-type" content="text/html;charset=UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Обновление сведений об образовательной организации</title>
    <link href="<?php echo $assetsDir?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo $assetsDir?>css/update-style.min.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript">
        var domen = location.protocol + '//' + '<?php echo $domenName; ?>';
        var apiDomen = '<?php echo $apiDomen; ?>';
        var clientId = '<?php echo $clientId; ?>';
        var currentVersion = '<?php echo $currentVersion; ?>';
        window.localStorage.setItem('vikon_code', '<?php echo isset($_GET['code']) ? $_GET['code'] : null ?>')
    </script>
    <script type="text/javascript" src="<?php echo $assetsDir?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $assetsDir?>js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $assetsDir?>js/update.min.js?v=<?php echo $currentVersion; ?>" defer></script>
</head>
<body>

<div class="wrapper container">

    <div class="main-wrapper">

        <header class="header">
            <h1>Обновление сведений об образовательной организации</h1>
            <hr>
        </header>

        <div class="container-fluid">

            <div class="form-group">
                <a href="/sveden" class="btn btn-primary">На главную</a>
                <a href="/sveden/update/index.php" class="btn btn-primary" id="exit" style="display: none;">Выход</a>
            </div>

            <div class="alert alert-danger" id="message-container" style="display: none;"></div>

            <div class="row" id="wait-load">
                <div class="text-center">
                    <img src="/build/images/throbber.gif">
                    идет загрузка страницы
                </div>
            </div>

            <div class="row" id="no-enter" style="display: none;">
                <div class="col-sm-12 text-center">
                    <h3>Требуется вход</h3>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="enter-vikon">
                            Войти через VIKON
                        </button>
                    </div>
                </div>
            </div>

            <div class="row" id="yes-enter" style="display: none;">
                <div class="col-sm-6">
                    <h3>Текущая версия системы: <span class="label label-default"><?php echo $currentVersion; ?></span></h3>
                    <div class="form-group settings-update" id="settings-update">
                        <h3>Обновление по частям:</h3>
                        <ul>
                            <li>
                                <div class="checkbox">
                                    <input type="checkbox" name="select-all" id="select-all" checked>
                                    <label for="select-all">Выбрать все</label>
                                </div>
                            </li>
                        </ul>
                        <b>Обновить следующие разделы:</b>
                        <ul>
                            <?php
                            $parts = json_decode($parts);
                            foreach ($parts as $partKey => $partVal) { ?>
                                <li>
                                    <div class="checkbox">
                                        <input type="checkbox" name="part" id="<?php echo $partKey; ?>" value="<?php echo $partKey; ?>" checked>
                                        <label for="<?php echo $partKey; ?>"><?php echo $partVal; ?></label>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <b>Синхронизация файлов:</b>
                        <ul>
                            <li>
                                <div class="checkbox">
                                    <input type="checkbox" name="sync" id="sync" value="sync" checked>
                                    <label for="sync">Синхронизировать файлы</label>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-sm-6">
                    <h3>Наличие обновления: <span class="label label-warning" id="new-version">получение информации...</span></h3>
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="start-update">Начать обновление</button>
                    </div>
                    <p class="alert alert-success" id="update-complete" style="display: none;"></p>
                    <div class="row" id="progressbar-container" style="display: none;">
                        <div class="col-xs-12">
                            <div class="progress">
                                <div id="progressbar" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-info process-container" id="process-container" style="display: none;"></div>
                </div>
            </div>

        </div>

        <?php require_once 'is_writable.php'; ?>
        <?php require_once 'check_curl.php'; ?>
    </div>

    <footer class="footer">
        <hr>
        <div class="text-center">
            <p class="copyright">
                Национальный фонд поддержки инноваций в сфере образования (НФПИ)
                <br>
                Copyright © 2013-<?php echo date('Y') ?>
            </p>
        </div>
    </footer>

</div>

</body>
</html>