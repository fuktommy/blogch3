{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>EDIT</title>
  <link rev="made" href="mailto:webmaster@fuktommy.com" />
  <link rel="contents" href="/blog" title="Top" />
  <link rel="stylesheet" type="text/css" href="/pc.css" />
  <link rel="meta" type="application/rdf+xml" title="license" href="/license" />
</head>
<body>
<h1>EDIT <a href="{$baseuri}">{$blogtitle}</a></h1>
{if $entry}
<h2><a href="{$baseuri}{$entry->id}">{$entry->title}</a></h2>
{/if}
<form method="post" action="./edit" id="edit"><p>
<input type="submit" value="SAVE" />
<input type="submit" value="PREVIEW" onclick="return preview();" />
{if $entry}
<input type="hidden" name="id" value="{$entry->id}" />
{/if}
<br />
{if $entry}
<textarea name="data" cols="80" rows="20" style="width: 90%;">{$entry->title|escape:"html"}

{$entry->body|escape:"html"}</textarea>
{else}
<textarea name="data" cols="80" rows="20" style="width: 90%;" onchange="return preview();"></textarea>
{/if}
</p></form>
<div id="preview"></div>
<script type="text/javascript">
{literal}
// <![CDATA[
function preview() {
    var prev = document.getElementById('preview');
    var edit = document.getElementById('edit');
    prev.innerHTML = edit.data.value;
    return false;
}
// ]]>
{/literal}
</script>
</body>
</html>
