<?php
function smarty_function_mobileAdsense($params, $smarty)
{
    $ua = $smarty->get_template_vars('ua');
    if ($ua['ads'] == 'google') {
        ini_set('default_socket_timeout', 5);
        include('googleMobileAdsense.php');

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
            $buf = mb_convert_encoding($buf, 'UTF-8', 'UTF-8,EUC-JP');
            $buf = str_replace('&amp;', '&', $buf);
            $buf = str_replace('&', '&amp;', $buf);
            $html .= $buf;
        }
        echo '<p style="text-align: center;">';
        echo $html;
        echo '</p>';
    }
}
