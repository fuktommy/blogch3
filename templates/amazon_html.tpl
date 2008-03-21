{* -*- coding: utf-8 -*- *}
{* Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>. *}
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
  <title>Amazon</title>
  <link rev="made" href="mailto:webmaster@fuktommy.com" />
  <link rel="contents" href="/" title="Top" />
</head>
<body>
<h1><a href="./amazon">Amazon</a></h1>
<ul>
  <li><a href="https://affiliate.amazon.co.jp/gp/associates/network/reports/main.html">Amazon Home</a></li>
  <li><a href="/data/amazon.js">Check Script</a></li>
</ul>
<form method="post" action="amazon"><p>
  <input type="submit" value="SAVE" /><br />
  <input type="hidden" name="sid" value="{$sid}" />
  <textarea cols="50" rows="40" name="data">{$data|escape:"html"}</textarea>
</p></form>
</body>
</html>
