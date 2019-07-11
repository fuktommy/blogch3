{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2014,2019 Satoshi Fukutomi <info@fuktommy.com>. *}
{if $smarty.now % 3 == 0}
{* 自動 *}
<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&amp;p=11&amp;l=ez&amp;f=ifr&amp;linkID=2c0a127537afaed6d8eed0976c1782e5&amp;t=fuktommy-22&amp;tracking_id=fuktommy-22" width="120" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
{elseif $smarty.now % 3 == 1}
{* 一般 *}
<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&amp;p=14&amp;l=ur1&amp;category=amazonrotate&amp;f=ifr&amp;linkID=5c840973f28b58d73c653587fb9f6307&amp;t=fuktommy-22&amp;tracking_id=fuktommy-22" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
{else}
{* 食品＆飲料 *}
<iframe src="https://rcm-fe.amazon-adsystem.com/e/cm?o=9&amp;p=14&amp;l=ur1&amp;category=foodbeverage&amp;f=ifr&amp;linkID=b6f43636b5aed733a900f8640881db71&amp;t=fuktommy-22&amp;tracking_id=fuktommy-22" width="160" height="600" scrolling="no" border="0" marginwidth="0" style="border:none;" frameborder="0"></iframe>
{/if}
