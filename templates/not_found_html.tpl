{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var="cssname" value="pc"}
{assign var="title" value="ファイルが見つかりませんでした"}
{include file="header.tpl"}
<h2>"{$resource|escape:"html"}" は見つかりませんでした。</h2>
<p>(404 Not Found)</p>
{include file="footer.tpl"}
