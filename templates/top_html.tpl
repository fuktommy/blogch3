{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="cssname" value="toppc"}
{assign var="title" value="blog.fuktommy.com"}
{include file="header.tpl"}
<div id="entries">
{foreach name="entries" from=$entries item="entry"}
{include file="entry.tpl"}
{/foreach}
<p id="footnavi"><a href="#searchbar" onclick="window.scroll(0,0); return false;">先頭に戻る</a></p>
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
