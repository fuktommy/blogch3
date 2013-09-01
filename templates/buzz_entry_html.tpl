{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010,2013 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=title value=$buzz->entry[0]|buzzTitle}
{assign var=entry_id value=$buzz->entry[0]->id|buzzid}
{assign var=mirrorlink value=$baseuri|cat:"buzz/"|cat:$entry_id}
{assign var=permalink value=$buzz->entry[0]->link.href|buzzPermalink:$mirrorlink}
{assign var=mobile_permalink value="`$mobileuri`buzz/`$entry_id`"}
{include file="header.tpl" title=$title mobile_permalink=$mobile_permalink}
{assign var=entry_html_mode value=true}
<div id="entries">
{foreach name="entries" from=$buzz->entry item="entry"}
    {include file="buzz_entry.tpl"}
{foreachelse}
    <p>記事がありません。</p>
{/foreach}
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
