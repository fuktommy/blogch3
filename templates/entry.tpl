{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
<div class="entry">
<h2 class="entrytitle"><a href="{$baseuri|escape}{$entry->id|escape}">{$entry->title|escape}</a></h2>
{$entry->body}
<ul class="feedback">
<li>{$entry->id|date_format:'<a href="/%Y-%m">%Y-%m</a>-%d %H:%M:%S'}</li>
<li><a href="http://blogsearch.google.com/blogsearch?q=link:{$baseuri|escape}{$entry->id|escape}&amp;scoring=d" class="backlink">
    この記事へのリンク</a></li>
<li><g:plusone href="{$baseuri|escape}{$entry->id|escape}" size="small"></g:plusone></li>
</ul>
{if $entry_html_mode || ($smarty.foreach.entries.iteration == 1)}
<div class="ads">
{include file="ads_entry_google.tpl"}
<noscript>
<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=fuktommy-22&amp;o=9&amp;p=13&amp;l=ez&amp;f=ifr&amp;f=ifr" width="468" height="60" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:none;"></iframe>
</noscript>
</div>
{/if}
</div>
