{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2011 Satoshi Fukutomi <info@fuktommy.com>. *}
{$entry[47]|default:$entry[4]}
{if $entry[47] && $entry[4] && ($entry[4] != $entry[47])}
    <blockquote><div>{$entry[4]}</div></blockquote>
{/if}
{foreach from=$entry[11] item="link"}
    <br /><a href="{$link[24][1]|escape}">{$link[3]}</a>
    <blockquote cite="{$link[24][1]|escape}"><div>{$link[21]}</div></blockquote>
{/foreach}
{if $entry[27]}
    <br /><a href="{$entry[27][9]|default:$entry[27][8]|escape}">{$entry[27][2]|default:$entry[27][3]|escape}</a>
{/if}
{foreach from=$entry[11] item="img"}
    {if $img[5][1]}
        <img src="{$img[5][1]|escape}" height="{$img[5][2]|escape}" width="{$img[5][3]|escape}" alt="" />
    {/if}
{/foreach}
