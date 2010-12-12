{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=permalink value=$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}
{assign var=title value=$entry->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}
{assign var=entry_id value=$entry->id|buzzid}
{assign var=mirrorlink value=$baseuri|cat:"buzz/"|cat:$entry_id}

<div class="entry"><h2 class="entrytitle"><a href="{$permalink|escape}">{$title|escape}</a></h2>

{$entry->content|formatBuzz}

{foreach from=$entry->link item=link}
    {if ($link.rel == "enclosure") && $link.title}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* 画像 *}
{buzzImage entry=$entry var=images}
{foreach from=$images item=img name=images}
    {if $smarty.foreach.images.iteration == 1}
        <br /><br />
    {/if}
    {strip}
    <a href="{$img.href|escape}">
    {if $entry_html_mode}
        {assign var=height value=$img.height/$img.width*256}
        <img src="{$img.src|escape}" alt="" width="256" height="{$height|escape}" alt="" />
    {elseif $img.preview}
        <img src="{$img.preview.src|escape}" alt="" width="{$img.preview.width}" height="{$img.preview.height}" alt="" />
    {else}
        【画像】
    {/if}
    </a>
    {/strip}
{/foreach}

{* ブクマ先リンク *}
{buzzLink entry=$entry var=links}
{foreach from=$links item=link}
    <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
{/foreach}

<ul class="feedback">
    <li><a href="{$mirrorlink|escape}">{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</a></li>
    <li><a href="http://www.google.com/buzz/post?url={$permalink|escape:"url"}" class="comments">コメントする</a></li>
    <li><a href="http://blogsearch.google.com/blogsearch?q=link:{$permalink|escape:"url"}&amp;scoring=d" class="backlink">この記事へのリンク</a></li>
    <li><span class="hatenastar"><a href="{$permalink|escape}" style="display:none;">{$title|escape}</a></span></li>
</ul>

{if $entry_html_mode}
    {include file="ads_entry_amazon.tpl"}
{elseif $category_id == "tanuki"}
    {if $smarty.foreach.entries.iteration == 1}
        {include file="ads_entry_amazon_tanuki.tpl"}
    {elseif $smarty.foreach.entries.iteration == 2}
        {include file="ads_entry_google.tpl"}
    {/if}
{else}
    {if $smarty.foreach.entries.iteration == 1}
        {include file="ads_entry_amazon_store.tpl"}
    {/if}
{/if}

</div>
