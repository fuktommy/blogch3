(function () {
    var form = document.getElementById('searchbar');
    var box = form.getElementsByTagName('input')[0];
    var inputMode = false;
    var description = 'Site Search by Google';

    box.onfocus = function () {
        if (! inputMode) {
            inputMode = true;
            box.value = '';
            box.style.color = '#000';
        }
    };

    function initBox() {
        if ((box.value == '') || (box.value == description)) {
            box.value = description;
            box.style.color = '#777';
            inputMode = false;
        }
    }

    box.onblur = initBox;
    initBox();
})();
