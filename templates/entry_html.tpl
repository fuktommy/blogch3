{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="cssname" value="toppc"}
{assign var="title" value=$entry->title}
{include file="header.tpl"}
<div id="entries">
    {include file="entry.tpl"}
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
