<?php
function smarty_modifier_buzzid($value)
{
    return strtr(base64_encode(md5((string)$value, true)),
                 array('+' => '-', '/' => '_', '=' => ''));
}
