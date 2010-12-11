{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=title value=$buzz->entry[0]->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}
{assign var=mobile_permalink value="http://www.google.co.jp/gwt/x?source=wax&ie=UTF-8&oe=UTF-8&u=`$buzz->entry[0]->link.href`"|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}
{include file="header.tpl" title=$title mobile_permalink=$mobile_permalink}
{assign var=entry_html_mode value=true}
<div id="entries">
{foreach name="entries" from=$buzz->entry item="entry"}
    {include file="buzz_entry.tpl"}
{/foreach}
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
