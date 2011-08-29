{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2010,2011 Satoshi Fukutomi <info@fuktommy.com>. *}
{include file="mobile_header.tpl" title="blog.fuktommy.com"}
{mobileAdsense}
<ul>
{foreach from=$buzz->entry item="entry"}
    {assign var=entry_id value=$entry->id|buzzid}
    <li><a href="{$mobileuri}buzz/{$entry_id|escape}">{$entry|buzzTitle|default:"(タイトルなし)"}</a></li>
{/foreach}
</ul>

{if isset($page)}
<ul>
    {if $page > 0}
        <li><a href="{$mobileuri}?page={$page-1|escape:"url"}" accesskey="*">
        新しいページ (*)</a></li>
    {/if}
    <li><a href="{$mobileuri}?page={$page+1|escape:"url"}" accesskey="#">昔のページ (#)</a></li>
</ul>
{/if}

{include file="mobile_footer.tpl"}
