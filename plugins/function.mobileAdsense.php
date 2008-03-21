<?php
function smarty_function_mobileAdsense($params, $smarty)
{
    $ua = $smarty->get_template_vars('ua');
    if ($ua['ads'] == 'google') {
        ini_set('default_socket_timeout', 5);
        $GLOBALS['google']['ad_type']   = 'text';
        $GLOBALS['google']['channel']   = '';
        $GLOBALS['google']['client']    = 'pub-0908882948816599';
        $GLOBALS['google']['format']    = 'mobile_single';
        $GLOBALS['google']['https']     = @$_SERVER['HTTPS'];
        $GLOBALS['google']['host']      = @$_SERVER['HTTP_HOST'];
        $GLOBALS['google']['ip']        = @$_SERVER['REMOTE_ADDR'];
        $GLOBALS['google']['markup']    = 'xhtml';
        $GLOBALS['google']['oe']        = 'utf8';
        $GLOBALS['google']['output']    = 'xhtml';
        $GLOBALS['google']['ref']       = @$_SERVER['HTTP_REFERER'];
        $GLOBALS['google']['url']       = @$_SERVER['HTTP_HOST'] . @$_SERVER['REQUEST_URI'];
        $GLOBALS['google']['useragent'] = @$_SERVER['HTTP_USER_AGENT'];
        $script = file_get_contents('http://pagead2.googlesyndication.com/pagead/show_ads.php');
        if ($script) {
            $script = preg_replace('/^<\?php|\?>\s*$/', '', $script);
            eval($script);
        }
    } elseif ($ua['ads'] == 'amazon') {
        // $files にディレクトリ内のファイル一覧を積む
        $conf = blogconfig();
        $d = dir($conf['adsense_dir']);
        $files = array();
        while (($f = $d->read()) !== false) {
            $f = $conf['adsense_dir'] . '/' . $f;
            if (is_file($f)) {
                $files[] = $f;
            }
        }
        $d->close();

        // HTMLコード生成
        $html = '';
        shuffle($files);
        foreach (array_slice($files, 0, 2) as $f) {
            $buf = file_get_contents($f);
            $buf = mb_convert_encoding($buf, 'UTF-8', 'EUC-JP');
            $buf = str_replace('&amp;', '&', $buf);
            $buf = str_replace('&', '&amp;', $buf);
            $html .= $buf;
        }
        echo '<p style="text-align: center;">';
        echo $html;
        echo '</p>';
    }
}

?>
