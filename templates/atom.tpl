{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2009,2019 Satoshi Fukutomi <info@fuktommy.com>. *}
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="/atomfeed.xsl" type="text/xsl"?>
<feed xmlns="http://www.w3.org/2005/Atom">
  <title>{$blogtitle|escape}</title>
  <subtitle>{$description}</subtitle>
  <link rel="self" href="{$atomuri|escape}" />
  <link rel="alternate" href="{$baseuri|escape}" type="text/html"/>
  <updated>{$smarty.now|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</updated>
  <generator>blogch3</generator>
  <id>{$atomuri|escape}</id>
  <author><name>{$creator|escape}</name></author>
{foreach from=$entries item="entry"}
  <entry>
    <title>{$entry->title|escape}</title>
    <link rel="alternate" href="{$baseuri|escape}{$entry->id|escape}"/>
    <summary type="text">{$entry->body|strip_tags:true|truncate:300:"..."|escape}</summary>
    <content type="html">{$entry->body|escape}</content>
    <published>{$entry->id|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</published>
    <updated>{$entry->id|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</updated>
    <author><name>{$creator|escape}</name></author>
    <id>{$baseuri|escape}{$entry->id|escape}</id>
    <rights>http://creativecommons.org/licenses/by/2.1/jp/</rights>
  </entry>
{/foreach}
</feed>
