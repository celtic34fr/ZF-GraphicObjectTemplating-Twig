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
    for (var idx = (noLine + 1); idx <= maxLine; idx++) {
        let tmp = $("#tabListParamsG7PP .lno"+idx);
        tmp.data("lno", (idx - 1));
        tmp.removeClass("lno"+idx).addClass("lno"+(idx-1));
    };
}

function updateCol(idTable, params) {
    let col = params['col'];
    let datas = params['datas'];

    $.each(datas,function (key, val) {
        $("#"+idTable+" .lno"+key+" .cno"+col).html(val);
    });
}

