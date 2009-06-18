{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2009 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="mobile_header.tpl" title=$entry->title}
<div style="background-color:#aaf;"><h2><span style="font-size:medium;">{$entry->title|escape:"html"}</span></h2></div>
{$entry->body}
<ul>
<li>{$entry->id|date_format:'<a href="/blog/%Y-%m">%Y-%m</a>-%d %H:%M:%S'}</li>
<li><a href="http://b.hatena.ne.jp/entrymobile/?url={$baseuri|escape:"url"}{$entry->id|escape:"url"}">Comments
    <img src="/blog/b_entry_de.gif" width="16" height="12" alt="" />
    <img src="http://b.hatena.ne.jp/entry/image/large/{$baseuri|escape:"url"}{$entry->id|escape:"url"}" alt="" /></a></li>
</ul>
{mobileAdsense}
{include file="mobile_footer.tpl"}
