{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="header.tpl" title="blog.fuktommy.com" cssname="toppc"}
<div id="entries">
{foreach name="entries" from=$buzz->entry item="entry"}
    {include file="buzz_entry.tpl"}
{/foreach}
<p id="footnavi">
{if isset($page)}
    {if $page > 0}
        <a href="{$baseuri}category/{$category_id|escape:"url"}/p{$page-1|escape:"url"}">新しいページ</a> | 
    {/if}
    <a href="{$baseuri}category/{$category_id|escape:"url"}/p{$page+1|escape:"url"}">昔のページ</a> |
{/if}
<a href="#searchbar" onclick="window.scroll(0,0); return false;">ページの先頭へ</a></p>
</div>
{include file="sidebar.tpl"}
{include file="footer.tpl"}
