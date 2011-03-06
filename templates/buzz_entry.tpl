{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2011 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=permalink value=$entry->link.href|buzzPermalink}
{assign var=entry_id value=$entry->id|buzzid}
{assign var=mirrorlink value=$baseuri|cat:"buzz/"|cat:$entry_id}

<div class="entry"><h2 class="entrytitle"><a href="{$permalink|escape}">{$entry->title}</a></h2>

{$entry->content|formatBuzz}

{foreach from=$entry->link item=link}
    {if ($link.rel == "enclosure") && $link.title}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* ブクマ先リンク *}
{buzzLink entry=$entry var=links}
{foreach from=$links item=link}
    <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
{/foreach}

{* 画像 *}
{buzzImage entry=$entry var=images}
{foreach from=$images item=img name=images}
    {if $smarty.foreach.images.iteration == 1}
        <br />
    {/if}
    {strip}
    {if $img.is_amazon && $link.href}
        <a href="{$link.href|escape}">
    {else}
        <a href="{$img.href|escape}">
    {/if}
    {if $entry_html_mode}
        {if $img.width}
            {assign var=width value=256}
            {assign var=height value=$img.height/$img.width*256}
        {else}
            {assign var=width value=""}
            {assign var=height value=""}
        {/if}
        <img src="{$img.src|escape}" alt="" width="{$width|escape}" height="{$height|escape}" alt="" />
    {elseif $img.preview}
        <img src="{$img.preview.src|escape}" alt="" width="{$img.preview.width}" height="{$img.preview.height}" alt="" />
    {else}
        【画像】
    {/if}
    </a>
    {/strip}
{/foreach}

{* 住所 *}
{buzzMap entry=$entry var=map}
{if $map}
   <p><a href="{$map.href|escape}">{$map.featureName|default:"地図"}</a><br />
      {if $map.address}{$map.address|escape}{/if}</p>
{/if}

<ul class="feedback">
    <li><a href="{$mirrorlink|escape}">{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</a></li>
    <li><a href="{$permalink|escape}" class="comments">コメントする</a></li>
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
