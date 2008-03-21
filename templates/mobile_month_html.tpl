{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="title" value=$entries->month}
{include file="mobile_header.tpl"}
<div style="background-color:#afa;"><h2><span style="font-size:medium;">{$entries->month}</span></h2></div>
<ul>
{foreach from=$entries item="row"}
<li>{$row[0]|date_format:"%Y-%m-%d"}
<a href="{$mobile_baseuri}{$row[0]}">{$row[1]|escape:"html"}</a></li>
{/foreach}
</ul>
{include file="mobile_footer.tpl"}
