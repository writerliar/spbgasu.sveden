<?php

    ini_set('max_execution_time', '60');
    ini_set('default_socket_timeout', '60');

    $authKey = '8fe803301f817442593a4158d43550ed';
    $domenName = 'www.spbgasu.ru';
    $apiDomen = 'https://db-nica.ru/';
    $useHttps = '0';
    $clientId = '692';
    $clientSecret = 'pq0bgagqtnmz8z7vh7hag83krbedeymtdkumm326dcub3rw0n50u235g50m9xwr38bcj44d86y9xeuxs';
    $parts = '{"common":"\u041e\u0441\u043d\u043e\u0432\u043d\u044b\u0435 \u0441\u0432\u0435\u0434\u0435\u043d\u0438\u044f","struct":"\u0421\u0442\u0440\u0443\u043a\u0442\u0443\u0440\u0430 \u0438 \u043e\u0440\u0433\u0430\u043d\u044b \u0443\u043f\u0440\u0430\u0432\u043b\u0435\u043d\u0438\u044f \u043e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u0442\u0435\u043b\u044c\u043d\u043e\u0439 \u043e\u0440\u0433\u0430\u043d\u0438\u0437\u0430\u0446\u0438\u0435\u0439","document":"\u0414\u043e\u043a\u0443\u043c\u0435\u043d\u0442\u044b","education":"\u041e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u043d\u0438\u0435","eduStandarts":"\u041e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u0441\u0442\u0430\u043d\u0434\u0430\u0440\u0442\u044b","employees":"\u0420\u0443\u043a\u043e\u0432\u043e\u0434\u0441\u0442\u0432\u043e. \u041f\u0435\u0434\u0430\u0433\u043e\u0433\u0438\u0447\u0435\u0441\u043a\u0438\u0439 (\u043d\u0430\u0443\u0447\u043d\u043e-\u043f\u0435\u0434\u0430\u0433\u043e\u0433\u0438\u0447\u0435\u0441\u043a\u0438\u0439) \u0441\u043e\u0441\u0442\u0430\u0432","objects":"\u041c\u0430\u0442\u0435\u0440\u0438\u0430\u043b\u044c\u043d\u043e-\u0442\u0435\u0445\u043d\u0438\u0447\u0435\u0441\u043a\u043e\u0435 \u043e\u0431\u0435\u0441\u043f\u0435\u0447\u0435\u043d\u0438\u0435 \u0438 \u043e\u0441\u043d\u0430\u0449\u0451\u043d\u043d\u043e\u0441\u0442\u044c \u043e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u0442\u0435\u043b\u044c\u043d\u043e\u0433\u043e \u043f\u0440\u043e\u0446\u0435\u0441\u0441\u0430","grants":"\u0421\u0442\u0438\u043f\u0435\u043d\u0434\u0438\u0438 \u0438 \u0438\u043d\u044b\u0435 \u0432\u0438\u0434\u044b \u043c\u0430\u0442\u0435\u0440\u0438\u0430\u043b\u044c\u043d\u043e\u0439 \u043f\u043e\u0434\u0434\u0435\u0440\u0436\u043a\u0438","paid_edu":"\u041f\u043b\u0430\u0442\u043d\u044b\u0435 \u043e\u0431\u0440\u0430\u0437\u043e\u0432\u0430\u0442\u0435\u043b\u044c\u043d\u044b\u0435 \u0443\u0441\u043b\u0443\u0433\u0438","budget":"\u0424\u0438\u043d\u0430\u043d\u0441\u043e\u0432\u043e-\u0445\u043e\u0437\u044f\u0439\u0441\u0442\u0432\u0435\u043d\u043d\u0430\u044f \u0434\u0435\u044f\u0442\u0435\u043b\u044c\u043d\u043e\u0441\u0442\u044c","vacant":"\u0412\u0430\u043a\u0430\u043d\u0442\u043d\u044b\u0435 \u043c\u0435\u0441\u0442\u0430 \u0434\u043b\u044f \u043f\u0440\u0438\u0435\u043c\u0430 (\u043f\u0435\u0440\u0435\u0432\u043e\u0434\u0430)","abitur":"\u0410\u0431\u0438\u0442\u0443\u0440\u0438\u0435\u043d\u0442\u0443"}';

    define('DEBUG_MODE', false);

    if (DEBUG_MODE === true) {
        error_reporting(E_ALL);
        ini_set('display_errors','on');
    } else {
        error_reporting(0);
    }

    require_once 'helper.php';