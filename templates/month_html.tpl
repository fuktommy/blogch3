{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="cssname" value="pc"}
{assign var="title" value=$entries->month}
{include file="header.tpl"}
<h2>{$entries->month}</h2>
<ul>
{foreach from=$entries item="row"}
<li>{$row[0]|date_format:"%Y-%m-%d"}
<a href="{$baseuri}{$row[0]}">{$row[1]|escape:"html"}</a></li>
{/foreach}
</ul>
{include file="footer.tpl"}
