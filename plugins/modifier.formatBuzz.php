<?php
function smarty_modifier_formatBuzz($value)
{
    $value = strtr($value, array(
        '<wbr>' => '',
        '<b>' => '',
        '</b>' => '',
    ));
    $value = preg_replace('|<p>Reshared post from\s*</p>\s*<blockquote .*?>(.*)</blockquote>\s*$|s', '$1', $value);
    $value = preg_replace('/^(\s|<br>)+/', '', $value);
    $value = preg_replace('|(<a href="http://blogsearch.google.co.jp/blogsearch[?]hl=ja&amp;[^"\' ]*)&amp;ie=utf-8|', '$1', $value);
    return $value;
}
