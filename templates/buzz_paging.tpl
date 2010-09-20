{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{strip}
{if isset($page)}
    {if $page > 0}
        <a href="{$baseuri}
        {if $category_id}
            category/{$category_id|escape:"url"}/p{$page-1|escape:"url"}
        {else}
            ?page={$page-1|escape:"url"}
        {/if}
        ">新しいページ</a> | {* *}
    {/if}
    <a href="{$baseuri}
    {if $category_id}
        category/{$category_id|escape:"url"}/p{$page+1|escape:"url"}
    {else}
        ?page={$page+1|escape:"url"}
    {/if}
    ">昔のページ</a> |
{/if}
{/strip}
