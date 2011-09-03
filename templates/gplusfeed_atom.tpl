{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2011 Satoshi Fukutomi <info@fuktommy.com>. *}
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="/atomfeed.xsl" type="text/xsl"?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>{$feed[1][0][0][3]|escape} - g+</title>
  <subtitle>{$feed[1][0][0][3]|escape}</subtitle>
  <link rel="self" href="http://blog.fuktommy.com/gplusfeed/{$feed[1][0][0][16]|escape}" />
  <link rel="alternate" href="https://plus.google.com/104787602969620799839/{$feed[1][0][0][16]|escape}/posts" type="text/html"/>
  <updated>{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</updated>
  <generator>GooglePlusFeedMaker</generator>
  <id>tag:fuktommy.com,2011:google/plusfeed</id>
  <author><name>{$feed[1][0][0][3]|escape}</name></author>
  <icon>https://ssl.gstatic.com/s2/oz/images/favicon.ico</icon>
{foreach from=$feed[1][0] item="entry"}
  <entry>
    <title>{$entry[47]|default:$entry[4]|default:$entry[11][0][3]|strip_tags|mb_substr:0:90:"utf-8"|default:"untitled"}</title>
    <link rel="alternate" href="https://plus.google.com/{$entry[21]|escape}"/>
    {if $entry[4]}<summary type="text">{$entry[47]|default:$entry[4]|strip_tags}</summary>{/if}
    <content type="html"><![CDATA[
        {include assign="content" file="gplusfeed_atom_content.tpl" entry=$entry}
        {$content|replace:"]]>":""}
    ]]></content>
    <published>{$entry[5]|substr:0:-3|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</published>
    <updated>{$entry[5]|substr:0:-3|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</updated>
    <author><name>{$feed[1][0][0][3]|escape}</name></author>
    <id>tag:fuktommy.com,2011:google/plusfeed/{$entry[8]|escape}</id>
    {if $feed[1][0][0][16] == "104787602969620799839"}
        <rights>http://creativecommons.org/licenses/by/2.1/jp/</rights>
    {/if}
  </entry>
{/foreach}
</feed>
