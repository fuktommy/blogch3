{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="header.tpl" title="blog.fuktommy.com" cssname="toppc"}
<div id="entries">
{foreach name="entries" from=$buzz->entry item="entry"}
    {include file="buzz_entry.tpl"}
{/foreach}
<p id="footnavi"><a href="#searchbar" onclick="window.scroll(0,0); return false;">先頭に戻る</a></p>
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
