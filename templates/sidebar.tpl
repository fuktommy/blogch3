{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
<div id="links">
<h2>カテゴリー</h2>
<ul>
  <li><a href="{$baseuri}category/tanuki">タヌキ</a></li>
  <li><a href="{$baseuri}category/article">長文記事</a></li>
  <li><a href="{$baseuri}category/photo">写真</a></li>
</ul>
<h2>リンク</h2>
<ul>
  <li><a href="http://fuktommy.com/">Fuktommy.com</a></li>
  <li><a href="https://plus.google.com/+%E8%AB%AD%E7%A6%8F%E5%86%A8Fuktommy?rel=author" rel="author">Google+</a></li>
  <li><a href="http://astore.amazon.co.jp/fuktommy-22">本</a></li>
  <li><a href="http://bbs.fuktommy.com/">掲示板</a></li>
  <li><a href="mailto:webmaster@fuktommy.com">メール</a></li>
</ul>
{if $category_id == "tanuki"}
    {include file="ads_sidebar_google.tpl"}
{/if}
<h2>つながり</h2>
<ul>
  <li><a href="http://blogsearch.google.com/blogsearch?q=link:https://plus.google.com/%252B%25E8%25AB%25AD%25E7%25A6%258F%25E5%2586%25A8Fuktommy/&amp;scoring=d">このブログへのリンク</a></li>
  <li><a href="http://feeds.feedburner.com/fuktommy">
      <img src="/feed-icon-16x16.gif" width="16" height="16" alt="" />
      Atom Feed</a></li>
  <li><a href="http://mobile.fuktommy.com/"><img src="/mobileqrcode.gif" width="132" height="132" alt="for Mobile" title="for Mobile" /></a></li>
</ul>

{if $category_id == "tanuki"}
    {include file="ads_sidebar_amazon.tpl"}
{/if}

<p>Powered by <a href="http://fuktommy.com/blogch/">blogch3</a>.</p>
</div>
