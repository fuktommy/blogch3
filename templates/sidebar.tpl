{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
<div id="links">
{if $index}
  <h2>過去記事</h2>
  <ul id="archives">
  {foreach from=$index item="month"}
    <li><a href="{$baseuri}{$month}">{$month}</a></li>
  {/foreach}
  </ul>
{/if}
<h2>リンク</h2>
<ul>
  <li><a href="http://fuktommy.com/">Fuktommy.com</a></li>
  <li><a href="https://plus.google.com/+%E8%AB%AD%E7%A6%8F%E5%86%A8Fuktommy?rel=author" rel="author">Google+</a></li>
  <li><a href="http://astore.amazon.co.jp/fuktommy-22">本</a></li>
  <li><a href="http://bbs.fuktommy.com/">掲示板</a></li>
  <li><a href="mailto:webmaster@fuktommy.com">メール</a></li>
</ul>
<h2>つながり</h2>
<ul>
  <li><a href="http://blogsearch.google.com/blogsearch?q=link:{$baseuri|escape:"url"}&amp;scoring=d">このブログへのリンク</a></li>
  <li><a href="/atom">
      <img src="/feed-icon-16x16.gif" width="16" height="16" alt="" />
      Atom Feed</a></li>
</ul>

{include file="ads_sidebar_google.tpl"}
{if ! $entry_html_mode}
  {include file="ads_sidebar_amazon.tpl"}
{/if}

<p>Powered by <a href="http://fuktommy.com/blogch/">blogch3</a>.</p>
</div>
