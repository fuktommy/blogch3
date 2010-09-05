{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
{assign var=permalink value=$entry->link.href|replace:"/buzz/104787602969620799839/":"/buzz/fuktommy/"}
{assign var=title value=$entry->summary|mb_substr:0:30:"utf8"}

<div class="entry"><h2 class="entrytitle"><a href="{$permalink|escape}">{$title|escape}</a></h2>

{$entry->content|formatBuzz}

{foreach from=$entry->link item=link}
    {if ($link.rel == "enclosure") && $link.title}
        <p><a href="{$link.href|escape}">{$link.title|escape}</a></p>
    {/if}
{/foreach}

{* 画像入れてみたけどいまいちだな…
{assign var=media value=$entry->children($xmlns_media)}
{foreach from=$media->content item=m}
    {assign var=content_attr value=$m->attributes()}
    {assign var=player_attr value=$m->player->attributes()}
    {if strpos($content_attr.url, "http://astore.amazon.co.jp/") === 0}
        <p><a href="{$content_attr.url|escape}"><img src="{$player_attr.url|escape}" alt="" /></a></p>
    {/if}
{/foreach}
*}

<ul class="feedback">
    <li>{$entry->updated|date_format:'%Y-%m-%d %H:%M:%S'}</li>
    <li><a href="http://www.google.com/buzz/post?url={$permalink|escape:"url"}" class="comments">コメントする</a></li>
    <li><a href="http://blogsearch.google.com/blogsearch?q=link:{$permalink|escape:"url"}&amp;scoring=d" class="backlink">この記事へのリンク</a></li>
    <li><span class="hatenastar"><a href="{$permalink|escape}" style="display:none;">{$title|escape}</a></span></li>
</ul>

{if $smarty.foreach.entries.iteration == 1}
<div class="ads">
<script type="text/javascript"><!--
  amazon_ad_tag = "fuktommy-22";
  amazon_ad_width = "468";
  amazon_ad_height = "60";
  amazon_ad_logo = "hide";
  amazon_color_border = "808080";
  amazon_color_background = "EFEFEF";
  amazon_color_link = "0000FF";
  amazon_color_price = "000000";
  amazon_color_logo = "FFFFFF";
//--></script>
<script type="text/javascript" src="http://www.assoc-amazon.jp/s/ads.js"></script>
<noscript>
<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=fuktommy-22&amp;o=9&amp;p=13&amp;l=ez&amp;f=ifr&amp;f=ifr" width="468" height="60" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:none;"></iframe>
</noscript>
</div>
{/if}

</div>
