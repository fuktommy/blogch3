{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2019 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=entry_id value=$entry->id|buzzid}
{assign var=mirrorlink value=$baseuri|cat:"buzz/"|cat:$entry_id}
{assign var=permalink value=$entry->link.href|buzzPermalink:$mirrorlink}

<div class="entry"><h2 class="entrytitle"><a href="{$permalink|escape}">{$entry|buzzTitle|default:"(タイトルなし)"}</a></h2>

{$entry->content|strval|default:$entry->summary|formatBuzz}

{foreach from=$entry->link item=link}
    {if ($link.rel == "enclosure") && ! empty($link.title)}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* ブクマ先リンク *}
{buzzLink entry=$entry var=links}
{foreach from=$links item=link}
    {if ! empty($link.href) && ! empty($link.title)}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* 画像 *}
{buzzImage entry=$entry var=images}
{foreach from=$images item=img name=images}
    {if $smarty.foreach.images.iteration == 1}
        <br />
    {/if}
    {strip}
    {if ! empty($img.is_amazon) && ! empty($link.href)}
        <a href="{$link.href|escape}">
    {else if ! empty($img.href)}
        <a href="{$img.href|escape}">
    {else}
        <a href="#">
    {/if}
    {if (! empty($entry_html_mode) || empty($img.preview)) && ! empty($img.src) && $img.is_buzz}
        {if ! empty($img.width)}
            {assign var=width value=256}
            {assign var=height value=$img.height/$img.width*256|intval}
        {else}
            {assign var=width value=""}
            {assign var=height value=""}
        {/if}
        <img src="{$img.src|escape}" width="{$width|escape}" height="{$height|escape}" alt="" />
    {elseif ! empty($img.preview)}
        <img src="{$img.preview.src|escape}" width="{$img.preview.width}" height="{$img.preview.height}" alt="" />
    {else}
        【画像】
    {/if}
    </a>
    {/strip}
{/foreach}

{* 住所 *}
{buzzMap entry=$entry var=map}
{if ! empty($map) && ! empty($map.href)}
   <p><a href="{$map.href|escape}">{$map.featureName|default:"地図"}</a><br />
      {if !empty($map.address)}{$map.address|escape}{/if}</p>
{/if}

<ul class="feedback">
    <li><a href="{$mirrorlink|escape}">{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</a></li>
    <li><a href="{$permalink|escape}" class="comments">コメント</a></li>
    <li><a href="http://blogsearch.google.com/blogsearch?q=link:{$permalink|escape:"url"}&amp;scoring=d" class="backlink">この記事へのリンク</a></li>
    <li><a href="https://plus.google.com/share?url={$permalink|escape:"url"}" target="_blank">g+で共有</a></li>
    <li><g:plusone href="{$permalink|escape}"></g:plusone></li>
</ul>

{if ! empty($entry_html_mode)}
    {include file="ads_entry_amazon.tpl"}
{elseif isset($category_id) && $category_id == "tanuki"}
    {if $smarty.foreach.entries.iteration == 1}
        {include file="ads_entry_amazon_tanuki.tpl"}
    {elseif $smarty.foreach.entries.iteration == 2}
        {include file="ads_entry_google.tpl"}
    {/if}
{else}
    {if $smarty.foreach.entries.iteration == 1}
        {include file="ads_entry_amazon.tpl" store=true}
    {/if}
{/if}

</div>
