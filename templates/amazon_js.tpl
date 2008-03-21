{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{literal}
(function() {
  var words = [
{/literal}
{foreach from=$keywords item="keyword" name="keywords"}
{if $smarty.foreach.keywords.last}
        '{$keyword|escape:"hex"}'
{else}
        '{$keyword|escape:"hex"}',
{/if}
{/foreach}
{literal}
    ];
    var frameWidth = 468;
    var frameHeight = 60;
    switch (amazon_live_type) {
        case 9:
            frameWidth = 180;
            frameHeight = 150;
            break;
        case 13:
            frameWidth = 468;
            frameHeight = 60;
            break;
    }
    var link = words[Math.floor(Math.random()*words.length)];
    link = 'http://rcm-jp.amazon.co.jp/e/cm?t=fuktommysstor-22&o=9' +
           '&p=' + amazon_live_type + '&l=st1&mode=books-jp' +
           '&search=' + link + '&' +
           '=1&fc1=&lt1=&lc1=&bg1=&lc1=0000FF&bg1=EFEFEF&f=ifr';
    link = link.replace('&', '&amp;');
    document.write(
        '<iframe src="' + link +'" marginwidth="0" marginheight="0"' +
        ' width="' + frameWidth +'"' +
        ' height="' + frameHeight + '" border="0" frameborder="0"' +
        ' style="border:none;" scrolling="no"></iframe>');
})();
{/literal}
