{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=title value=$buzz->entry[0]->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}
{assign var=entry_id value=$buzz->entry[0]->id|buzzid}
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
