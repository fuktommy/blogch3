{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=entry value=$buzz->entry[0]}
{assign var=permalink value=$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}
{assign var=title value=$entry->content|formatBuzz|strip_tags|mb_substr:0:30:"utf8"}

{include file="mobile_header.tpl" title=$title}

{if ! $buzz->entry}
    <p>記事がありません。</p>
{/if}

<div style="background-color:#aaf;"><h2><span style="font-size:medium;">{$title|escape}</span></h2></div>

{$entry->content|formatBuzz}

{foreach from=$entry->link item=link}
    {if ($link.rel == "enclosure") && $link.title}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* 画像 *}
{if $entry}
    {assign var=media value=$entry->children($xmlns_media)}
{/if}
{foreach from=$media->content item=m name=media}
    {assign var=content_attr value=$m->attributes()}
    {assign var=player_attr value=$m->player->attributes()}
    {if $smarty.foreach.media.iteration == 1}
        <br />
    {/if}
    {if ($content_attr.medium == "image") && ($content_attr.url == "")}
        <a href="{$player_attr.url|escape}">【画像】</a>
    {/if}
{/foreach}

<ul>
    <li>{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</li>
</ul>

{mobileAdsense}
</div>

{include file="mobile_footer.tpl"}
