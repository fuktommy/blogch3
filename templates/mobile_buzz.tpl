{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="mobile_header.tpl" title="blog.fuktommy.com"}
{mobileAdsense}
<ul>
{foreach from=$buzz->entry item="entry"}
    <li><a href="{$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}">{$entry->summary|mb_substr:0:30:"utf8"}</a></li>
{/foreach}
</ul>
{include file="mobile_footer.tpl"}
