{* Copyright (c) 2007-2014 Satoshi Fukutomi <info@fuktommy.com>. *}
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>{$title}</title>
  {if $meta_description}
    <meta name="description" content="{$meta_description|escape}" />
  {/if}
  {if $meta_keywords}
    <meta name="keywords" content="{$meta_keywords|escape}" />
  {/if}
  <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=0.1, maximum-scale=10.0, user-scalable=yes" />
  <link rel="author" href="{$homepage}" />
  <link rel="contents" href="/" title="Top" />
  <link rel="stylesheet" type="text/css" href="/mobile.css" media="handheld" />
  <link rel="stylesheet" type="text/css" href="/{$cssname|default:"pc"}.css" media="screen,tv" />
  <link rel="stylesheet" type="text/css" href="/touch.css" media="screen and (max-width: 500px)" />
  <link rel="stylesheet" type="text/css" href="/print.css" media="print,projection " />
  {if $permalink}
    <link rel="canonical" href="{$permalink|escape}" />
  {/if}
  <link rel="alternate" type="application/atom+xml" title="Atom" href="{$baseuri}atom" />
  <link rel="license" type="application/rdf+xml" href="/license" />
</head>
<body>
{strip}
<h1><a href="{$baseuri}">
  <span style="color:#30a72f">i</span>
  <span style="color:#c41200">t</span>
  <span style="color:#0039b6">e</span>
  <span style="color:#c41200">m</span>
  <span style="color:#f3c518">.</span>
  <span style="color:#0039b6">f</span>
  <span style="color:#c41200">u</span>
  <span style="color:#f3c518">k</span>
  <span style="color:#0039b6">t</span>
  <span style="color:#30a72f">o</span>
  <span style="color:#c41200">m</span>
  <span style="color:#0039b6">m</span>
  <span style="color:#c41200">y</span>
  <span style="color:#f3c518">.</span>
  <span style="color:#0039b6">c</span>
  <span style="color:#30a72f">o</span>
  <span style="color:#0039b6">m</span>
</a>
</h1>
{/strip}
<form action="http://www.google.com/cse" id="searchbar"><p>
  <input type="text" name="q" size="31" />
  <input type="hidden" name="cx" value="003570941829906538055:5apetotzz44" />
  <input type="hidden" name="ie" value="UTF-8" />
</p></form>
<script type="text/javascript" src="http://www.google.com/coop/cse/brand?form=searchbar&amp;lang=ja"></script>
