// Call Google Feeds API
// Copyright (c) 2007 Satoshi Fukutomi <info@fuktommy.com>.
(function () {
    google.load('feeds', '1');

    function initialize() {
        var anchors = document.getElementsByTagName('a');
        for (var i=0; i<anchors.length; i++) {
            if (anchors[i].className != 'backlink') {
                continue;
            }
            var feedURL = anchors[i].href.replace('blogsearch?', 'blogsearch_feeds?');
            var feed = new google.feeds.Feed(feedURL);
            feed.setNumEntries(10);
            feed.load((function (a) {
                return function (result) {
                    if (! result.error) {
                        var n = result.feed.entries.length;
                        if (n >= 10) {
                            a.appendChild(document.createTextNode(' (10+)'));
                        } else if (n > 0) {
                            a.appendChild(document.createTextNode(' (' + n + ')'));
                        }
                    }
                }
            })(anchors[i]));
        }
    }

    google.setOnLoadCallback(initialize);
})();
