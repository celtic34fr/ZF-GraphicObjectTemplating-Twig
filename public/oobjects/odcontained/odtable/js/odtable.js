function odtable(obj) {
    this.id = obj.attr('id');
}

odtable.prototype = {
    getData: function (evt) {

    },
    setData: function (data) {

    },
    rmLineUpdate(params) {
        let noLine  = params['noLine'];
        let maxLine = params['maxLine'];
        for (let idx = (noLine + 1); idx <= maxLine; idx++) {
            let tmp     = $("#"+this.id+" .lno"+idx);
            let pIdx    = idx - 1;
            tmp.attr("data-lno", pIdx);
            tmp.removeClass("lno"+idx).addClass("lno"+pIdx);
        }
    },
    updateCol(params) {
        let col = params['col'];
        let datas = params['datas'];

        $.each(datas,function (key, val) {
            $("#"+this.id+" .lno"+key+" .cno"+col).html(val);
        });
    },
};



