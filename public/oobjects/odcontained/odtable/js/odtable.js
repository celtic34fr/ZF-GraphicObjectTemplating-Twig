function odtable(obj) {
    this.id = obj.attr('id');
}

odtable.prototype = {
    getData: function (evt) {

    },
    setData: function (data) {

    },
};

function rmLineUpdate(noLine, maxLine) {
    for (var idx = (noLine + 1); idx <= (maxLine + 1); idx++) {
        $("#tabListParamsG7PP .lno"+idx).data("lno", (idx - 1));
        $("#tabListParamsG7PP .lno"+idx+" .cno1").html(idx - 1);
        $("#tabListParamsG7PP .lno"+idx).removeClass("lno"+idx).addClass("lno"+(idx-1));
    };
}