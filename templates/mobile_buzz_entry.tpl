{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=entry value=$buzz->entry[0]}
{assign var=permalink value=$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}
{assign var=title value=$entry->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}

{include file="mobile_header.tpl" title=$title}

{if ! $buzz->entry}
    <p>記事がありません。</p>
{/if}

<div style="background-color:#aaf;"><h2><span style="font-size:medium;">{$title}</span></h2></div>

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
    {if $img.preview}
        <img src="{$img.preview.src|escape}" alt="" width="{$img.preview.width}" height="{$img.preview.height}" alt="" /><br />
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

{* 住所 *}
{buzzMap entry=$entry var=map}
{if $map}
    <p>{if $map.featureName}{$map.featureName}<br />{/if}
    <a href="{$map.href|escape}">{$map.address|escape}</a></p>
{/if}

<ul>
    <li>{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</li>
</ul>

{mobileAdsense}
</div>

{include file="mobile_footer.tpl"}
