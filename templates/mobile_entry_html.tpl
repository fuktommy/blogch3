{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="title" value=$entry->title}
{include file="mobile_header.tpl"}
<div style="background-color:#afa;"><h2><span style="font-size:medium;">{$entry->title|escape:"html"}</span></h2></div>
{$entry->body}
<ul>
<li>{$entry->id|date_format:'<a href="/blog/%Y-%m">%Y-%m</a>-%d %H:%M:%S'}</li>
<li><a href="http://b.hatena.ne.jp/entrymobile/?url={$baseuri|escape:"url"}{$entry->id|escape:"url"}">Comments
    <img src="/blog/b_entry_de.gif" width="16" height="12" alt="" />
    <img src="http://b.hatena.ne.jp/entry/image/large/{$baseuri|escape}{$entry->id|escape}" alt="" /></a></li>
</ul>
{mobileAdsense}
{include file="mobile_footer.tpl"}
