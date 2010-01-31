// Call Google Feeds API
// Copyright (c) 2007,2010 Satoshi Fukutomi <info@fuktommy.com>.
(function () {
    google.load('feeds', '1');

    function generateCallback(anchor) {
        return function (result) {
            if (result.error) {
                return;
            }
            var n = result.feed.entries.length;
            if (n >= 10) {
                anchor.appendChild(document.createTextNode(' (10+)'));
            } else if (n > 0) {
                anchor.appendChild(document.createTextNode(' (' + n + ')'));
            }
        }
    }

    function loadFeed(feedUrl, anchor) {
        var feed = new google.feeds.Feed(feedUrl);
        feed.setNumEntries(10);
        feed.load(generateCallback(anchor));
    }

    function doBacklink(anchor) {
        var feedUrl = anchor.href.replace('blogsearch?', 'blogsearch_feeds?');
        loadFeed(feedUrl, anchor);
    }

    function doComments(anchor) {
        var feedUrl = anchor.href.replace(
                'http://search.twitter.com/search?q=',
                'http://search.twitter.com/search.atom?q=');
        loadFeed(feedUrl, anchor);
    }

    function initialize() {
        var anchors = document.getElementsByTagName('a');
        for (var i=0; i<anchors.length; i++) {
            if (anchors[i].className == 'backlink') {
                doBacklink(anchors[i]);
            } else if (anchors[i].className == 'comments') {
                doComments(anchors[i]);
            }

        }
    }

    google.setOnLoadCallback(initialize);
})();
