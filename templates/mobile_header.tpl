{* -*- coding: UTF-8 -*- *}
{* Copyright (c) 2007-2009 Satoshi Fukutomi <info@fuktommy.com>. *}
{if $ua.xhtml}
<?xml version="1.0" encoding="{$ua.encoding}"?>
{/if}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML Basic 1.0//EN"
    "http://www.w3.org/TR/xhtml-basic/xhtml-basic10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset={$ua.encoding}" />
  <title>{$title}</title>
  {literal}
  <style type="text/css"><![CDATA[
  p, ul, ol, dl, pre {
    margin-bottom: 1ex;
  }
  ]]></style>
  {/literal}
  {if $entry}
    <link rel="canonical" href="{$baseuri|escape}{$entry->id|escape}" />
  {/if}
</head>
<body style="background-color:#efefef;">
{strip}
<h1><span style="font-size:medium;"><a href="{$mobile_baseuri}">blog.fuktommy.com</a></span></h1>
{/strip}
