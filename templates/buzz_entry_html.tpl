{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=title value=$buzz->entry[0]->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}
{include file="header.tpl" title=$title cssname="toppc"}
{assign var=entry_html_mode value=true}
<div id="entries">
{foreach name="entries" from=$buzz->entry item="entry"}
    {include file="buzz_entry.tpl"}
{/foreach}
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
