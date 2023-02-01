{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
<div id="links">
{if ! empty($index)}
  <h2>過去記事</h2>
  <ul id="archives">
  {foreach from=$index item="month"}
    <li><a href="{$baseuri}{$month}">{$month}</a></li>
  {/foreach}
  </ul>
{/if}
<h2>リンク</h2>
<ul>
  <li><a href="https://fuktommy.com/">Fuktommy.com</a></li>
  <li><a href="https://twitter.com/fuktommy">twitter</a></li>
  <li><a href="https://www.amazon.co.jp/hz/wishlist/ls/3VGI29TIGSZ8?tag=fuktommy-22">ほしい物リスト</a></li>
  <li><a href="mailto:webmaster@fuktommy.com">メール</a></li>
</ul>
<h2>つながり</h2>
<ul>
  <li><a href="/atom">
      <img src="/feed-icon-16x16.gif" width="16" height="16" alt="" />
      Atom Feed</a></li>
</ul>

{if empty($entry_html_mode)}
  {include file="ads_sidebar_amazon.tpl"}
{/if}
{*
{include file="ads_sidebar_google.tpl"}
*}

<p>Powered by <a href="https://fuktommy.com/blogch/">blogch3</a>.</p>
</div>
