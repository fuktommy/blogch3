{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2020 Satoshi Fukutomi <info@fuktommy.com>. *}
<div id="links">
{if ! empty($index)}
  <h2>過去記事</h2>
  <ul id="archives">
  {foreach from=$index item="month"}
    <li><a href="{$baseuri}{$month}">{$month}</a></li>
  {/foreach}
  </ul>
{/if}
<h2>カテゴリー</h2>
<ul>
  <li><a href="{$baseuri}category/tanuki">タヌキ</a></li>
  <li><a href="{$baseuri}category/article">長文記事</a></li>
  <li><a href="{$baseuri}category/photo">写真</a></li>
</ul>
<h2>リンク</h2>
<ul>
  <li><a href="https://fuktommy.com/">Fuktommy.com</a></li>
  <li><a href="mailto:webmaster@fuktommy.com">メール</a></li>
</ul>
{if isset($category_id) && $category_id == "tanuki"}
    {include file="ads_sidebar_google.tpl"}
{/if}
<h2>つながり</h2>
<ul>
  <li><a href="https://feeds.feedburner.com/fuktommy">
      <img src="/feed-icon-16x16.gif" width="16" height="16" alt="" />
      Atom Feed</a></li>
  <li><div class="p7-b" data-p7id="8b4d08a4415949e481b2975596b00778" data-p7c="r"></div>
      <script src="https://fuktommy.app.push7.jp/static/button/p7.js"></script></li>
</ul>

{include file="ads_sidebar_amazon.tpl"}

<p>Powered by <a href="http://fuktommy.com/blogch/">blogch3</a>.</p>
</div>
