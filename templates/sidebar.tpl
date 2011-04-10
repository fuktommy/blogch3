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
  <li><a href="https://profiles.google.com/fuktommy/about">Google バズ</a></li>
  <li><a href="http://astore.amazon.co.jp/fuktommy-22">本</a></li>
  <li><a href="http://bbs.fuktommy.com/">掲示板</a></li>
  <li><a href="mailto:webmaster@fuktommy.com">メール</a></li>
</ul>
{if $category_id == "tanuki"}
    {include file="ads_sidebar_google.tpl"}
{/if}
<h2>つながり</h2>
<ul>
  <li><a href="http://blogsearch.google.com/blogsearch?q=link:http://www.google.com/buzz/fuktommy/&amp;scoring=d">このブログへのリンク</a></li>
  <li><a href="http://feeds.feedburner.com/fuktommy_buzz">
      <img src="/feed-icon-16x16.gif" width="16" height="16" alt="" />
      Atom Feed</a></li>
  <li><a href="http://fusion.google.com/add?feedurl=http://feeds.feedburner.com/fuktommy_buzz"><img src="http://buttons.googlesyndication.com/fusion/add.gif" width="104" height="17" alt="Add to Google" /></a></li>
  <li><form action="https://www.paypal.com/cgi-bin/webscr" method="post"><div>
        <input type="hidden" name="cmd" value="_s-xclick" />
        <input type="hidden" name="hosted_button_id" value="7210101" />
        <input type="image" src="https://www.paypal.com/ja_JP/JP/i/btn/btn_paynow_SM.gif" name="submit" alt="PayPal - オンラインで安全・簡単にお支払い" />
        <img alt="" src="https://www.paypal.com/ja_JP/i/scr/pixel.gif" width="1" height="1" />
      </div></form></li>
  <li><a href="http://mobile.fuktommy.com/"><img src="/mobileqrcode.gif" width="132" height="132" alt="for Mobile" title="for Mobile" /></a></li>
</ul>

{if $category_id == "tanuki"}
    {include file="ads_sidebar_amazon.tpl"}
{/if}

<p>Powered by <a href="http://fuktommy.com/blogch/">blogch3</a>.</p>
</div>
