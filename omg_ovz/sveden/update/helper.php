<?php

    class getResult
    {
        public $success = false;
        public $message = 'Не удается получить данные от удаленного сервера';
        public $info = '';
    }

    function getRemoteData($url, $opts = NULL, $decode = true, $postFields = false)
    {
        $result = new getResult();
        $result->success = false;
        if (function_exists('curl_init')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST , 0);
            if (is_array($postFields)) {
                curl_setopt($ch, CURLOPT_POST , true);
                $postVars = "";
                foreach($postFields as $key => $value) {
                    $postVars .= $key . '=' . $value . '&';
                }
                $postVars = rtrim($postVars ,'&');
                curl_setopt($ch, CURLOPT_POSTFIELDS , $postVars);
            } else {
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
            }
            $output = curl_exec($ch);
            if (curl_errno($ch) > 0 || curl_error($ch)) {
                if (DEBUG_MODE === true) {
                    $result->message .= ';' . '#:' . curl_errno($ch) . 'Error:' . curl_error($ch);
                }
                $output = getContents($url, $opts);
            }
            curl_close($ch);
        } else {
            $output = getContents($url, $opts);
        }
        if ($output) {
            $result->success = true;
            $result->info = ($decode) ? json_decode($output) : $output;
        }
        return $result;
    }

    function getContents($url, $opts)
    {
        return file_get_contents($url, false, ($opts != NULL) ? stream_context_create($opts) : NULL);
    }

    function loadHeaders()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Content-type: application/json');
    }

    function removeDirectory($dir)
    {
        $success = false;
        if (file_exists($dir)) {
            if ($objs = glob($dir . "/*")) {
                foreach ($objs as $obj) {
                    is_dir($obj) ? removeDirectory($obj) : unlink($obj);
                }
            }
            $success = rmdir($dir);
        }
        return $success;
    }

    function unpackZip($fileName, $pathToUnpack = "./../../")
    {
        $res['success'] = false;
        $res['message'] = '';
        if (extension_loaded('zip')) {
            $zip = new ZipArchive;
            if ($isOpenedZip = $zip->open($fileName)) {
                $zip->extractTo($pathToUnpack);
                $zip->close();
                $res['success'] = true;
            } else {
                $res['message'] = 'Ошибка при распоковке файлов библиотеки ZIP:' . $isOpenedZip;
            }
        } else {
            require_once 'zip_helper.php';
            $archive = new PclZip($fileName);
            $unZipResult = $archive->extract(PCLZIP_OPT_PATH, $pathToUnpack,
                PCLZIP_CB_PRE_EXTRACT, 'preExtractCallback', PCLZIP_OPT_REPLACE_NEWER);
            if ($unZipResult == 0) {
                $res['message'] = 'Ошибка при распоковке файлов:' . $archive->errorInfo(true);
            } else {
                $res['success'] = true;
            }
        }
        return $res;
    }

    function preExtractCallback($preEvent, &$preHeader)
    {
        if (!is_dir($preHeader['filename'])) {
            if (strpos($preHeader['filename'], '.htaccess')) {
                return 0;
            }
            if (file_exists($preHeader['filename'])) {
                unlink($preHeader['filename']);
            }
        }
        return 1;
    }

    function filterAccessToken($token)
    {
        return filter_var($token, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-z0-9]+$/')));
    }

    function filterFileName($file)
    {
        return filter_var($file, FILTER_VALIDATE_REGEXP,
            array('options' => array('regexp' => '/^[a-z0-9\+\.\,\(\)\;\#\№\-\_\«\»\!\%\=\$\@\'\&\–]+$/i'))
        );
    }

    function filterInt($number)
    {
        return filter_var($number, FILTER_VALIDATE_INT);
    }

    function filterUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    function filterVersion($version)
    {
        return filter_var($version, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[0-9\.]+$/')));
    }

    function filterPartName($part)
    {
        return filter_var($part, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => '/^[a-z\_]+$/i')));
    }

    function logFile($message) {
        $file_name = date("Y_m_d")."_log.log";
        // Запись в файл
        $file = fopen($file_name, 'a+');
        fwrite($file, date('Y-m-d H:i:s') . ' --- ' . $message . "\r\n");
        fclose($file);
    }
