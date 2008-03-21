{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="title" value="blog.fuktommy.com"}
{include file="mobile_header.tpl"}
<ul>
{foreach from=$index item="month"}
<li><a href="{$mobile_baseuri}{$month}">{$month}</a></li>
{/foreach}
</ul>
{include file="mobile_footer.tpl"}
