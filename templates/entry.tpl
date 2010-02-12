{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007-2010 Satoshi Fukutomi <info@fuktommy.com>. *}
<div class="entry">
<h2 class="entrytitle"><a href="{$baseuri|escape}{$entry->id|escape}">{$entry->title|escape}</a></h2>
{$entry->body}
<ul class="feedback">
<li>{$entry->id|date_format:'<a href="/%Y-%m">%Y-%m</a>-%d %H:%M:%S'}</li>
<li><a href="http://www.google.com/reader/link?url={$baseuri|escape:"url"}{$entry->id|escape:"url"}&amp;title={$entry->title|escape:"url"}&srcURL={$baseuri|escape:"url"}" class="comments">コメントする</a></li>
<li><a href="http://blogsearch.google.com/blogsearch?q=link:{$baseuri|escape}{$entry->id|escape}&amp;scoring=d" class="backlink">
    この記事へのリンク</a></li>
{if $entry_html_mode || ($smarty.foreach.entries.iteration == 1)}
<li>[[<a href="http://bbs.shingetsu.info/" id="shingetsu_link">新月</a>]]</li>
{/if}
<li><span class="hatenastar"><a href="{$baseuri|escape}{$entry->id|escape}" style="display:none;">{$entry->title|escape}</a></span></li>
</ul>
<script type="text/javascript" src="http://bbs.shingetsu.info/suggest.js"></script>
{if $entry_html_mode || ($smarty.foreach.entries.iteration == 1)}
<div class="ads">
{if $entry_html_mode}
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
{*
<script type="text/javascript"><!--
google_ad_client = "pub-0908882948816599";
google_ad_width = 468;
google_ad_height = 60;
google_ad_format = "468x60_as";
google_ad_type = "text_image";
google_ad_channel = "";
google_color_border = "808080";
google_color_bg = "EFEFEF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "008000";
google_ui_features = "rc:6";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
*}
{else}
<script type="text/javascript"><!--
amazon_ad_tag="fuktommy-22"; 
amazon_ad_width="468"; 
amazon_ad_height="60"; 
amazon_color_background="EFEFEF"; 
amazon_color_border="000000"; 
amazon_color_logo="FFFFFF"; 
amazon_color_link="0000FF"; //--></script>
<script type="text/javascript" src="http://www.assoc-amazon.jp/s/asw.js"></script>
{/if}
<noscript>
<iframe src="http://rcm-jp.amazon.co.jp/e/cm?t=fuktommy-22&amp;o=9&amp;p=13&amp;l=ez&amp;f=ifr&amp;f=ifr" width="468" height="60" scrolling="no" marginwidth="0" marginheight="0" frameborder="0" style="border:none;"></iframe>
</noscript>
</div>
{/if}
</div>
