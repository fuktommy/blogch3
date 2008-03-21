(function () {
    var hidden = false;
    var linklist = document.getElementById('archives');
    var links = linklist.getElementsByTagName('li');
    for (var i=0; i<links.length; i++) {
        if (5 < i) {
            links[i].style.display = 'none';
            hidden = true;
        }
    }
    if (hidden) {
        var anc = document.createElement('a');
        anc.onclick = function(){
            for (var i=0; i<links.length; i++) {
                links[i].style.display = 'block';
            }
            links[links.length-1].style.display = 'none';
            return false;
        };
        anc.href = 'javascript:;';
        anc.innerHTML = 'もっと古い記事';
        var li = document.createElement('li');
        li.appendChild(anc);
        linklist.appendChild(li);
    }
})();
