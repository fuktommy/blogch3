{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007,2019 Satoshi Fukutomi <info@fuktommy.com>. *}
<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet href="/rss1.xsl" type="text/xsl"?>
<rdf:RDF
  xmlns="http://purl.org/rss/1.0/"
  xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
  xmlns:content="http://purl.org/rss/1.0/modules/content/"
  xmlns:dc="http://purl.org/dc/elements/1.1/"
  xmlns:cc="http://web.resource.org/cc/"
  xml:lang="ja">
<channel rdf:about="{$baseuri}">
  <title>{$blogtitle}</title>
  <link>{$baseuri}</link>
  <description>{$description}</description>
  <dc:creator>{$creator}</dc:creator>
  <items><rdf:Seq>
{foreach from=$entries item="entry"}
    <rdf:li rdf:resource="{$baseuri}{$entry->id}"/>
{/foreach}
</rdf:Seq></items></channel>
{foreach from=$entries item="entry"}
  <item rdf:about="{$baseuri}{$entry->id}">
  <title>{$entry->title|escape:"html"}</title>
  <link>{$baseuri}{$entry->id}</link>
  <dc:date>{$entry->id|date_format:"%Y-%m-%dT%H:%M:%S"}{$w3ctimezone}</dc:date>
  <dc:creator>{$creator}</dc:creator>
  <dc:rights>http://creativecommons.org/licenses/by/2.1/jp/</dc:rights>
  <cc:license rdf:resource="{$baseuri}{$entry->id}"/>
  <description>{$entry->body|strip_tags:true|truncate:900:"..."|escape:"html"}</description>
  <content:encoded><![CDATA[{$entry->body}]]></content:encoded>
</item>
{/foreach}
</rdf:RDF>
