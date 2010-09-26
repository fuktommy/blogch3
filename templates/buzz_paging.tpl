{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{strip}
{if isset($page)}
    {if $page > 0}
        <a href="{$baseuri}
        {if $category_id}
            category/{$category_id|escape:"url"}
        {/if}
        ?page={$page-1|escape:"url"}
        ">新しいページ</a> | {* *}
    {/if}
    <a href="{$baseuri}
    {if $category_id}
        category/{$category_id|escape:"url"}
    {/if}
    ?page={$page+1|escape:"url"}
    ">昔のページ</a> |
{/if}
{/strip}
