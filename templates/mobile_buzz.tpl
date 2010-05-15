{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="mobile_header.tpl" title="blog.fuktommy.com"}
{mobileAdsense}
<ul>
{foreach from=$buzz->entry item="entry"}
    <li><a href="http://www.google.co.jp/gwt/x?source=wax&amp;ie=UTF-8&amp;oe=UTF-8&amp;u={$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"|escape:"url"}">{$entry->summary|mb_substr:0:30:"utf8"}</a></li>
{/foreach}
</ul>
{include file="mobile_footer.tpl"}
