function odtable(obj) {
    this.id     = obj.attr('id');
    this.pager  = obj.data('pager');
}

function addBtnActions(idObj) {
    var selector = '#' + idObj + ' tr > td.cnoActions';
    var nodes    = $(selector);
    $.each(nodes, function () {
        btnActions = $(this).data('btnactions');
        btnActions = btnActions.split('|');
        liNode     = $(this).parent('tr');

        if ($(this).is(':empty')) {
            btnActions.forEach(function (btnName) {
                var button = $('#' + idObj + 'BtnsAction #' + btnName)[0].outerHTML;
                button = button.replace(btnName, liNode.data('lno') + btnName);
                liNode.find('> td.cnoActions').append(button);
            })
        }
    });
}

odtable.prototype = {
    getData: function (evt) {

    },
    setData: function (data) {

    },
    rmLineUpdate: function(params) {
        let noLine  = parseInt(params['noLine']);
        let maxLine = parseInt(params['maxLine']);
        $("#" + this.id+" .lno"+noLine).remove()
        if (noLine < maxLine) {
            for (let idx = (noLine + 1); idx <= maxLine; idx++) {
                let selector = "#"+this.id+" .lno"+idx;
                let tmp     = $(selector);
                let pIdx    = idx - 1;
                tmp.attr("data-lno", pIdx);
                tmp.removeClass("lno"+idx).addClass("lno"+pIdx);
            }
            $("#"+this.id+" .line.nodata").removeClass('hide').addClass('hide');
        } else if (noLine == 1 && maxLine == 1) {
            $("#"+this.id+" .line.nodata").removeClass('hide');
        } else {
            $("#"+this.id+" .line.nodata").removeClass('hide').addClass('hide');
        }
    },
    updateCol: function(params) {
        let col   = params['col'];
        let datas = params['datas'];
        let id    = this.id;

        $.each(datas,function (key, val) {
            let selector = "#" + id + " .lno" + key + " .cno" + col;
            $(selector).html(val);
        });
    },
    filterSearch: function(search) {
        if (!this.pager) {
            $("#"+this.id+" tr").each(function () {
                this.find("td").each(function () {
                    if(this.html().indexOf(search) != -1){
                        $(this).parent().addClass('hide');
                    }
                });
            });
        }
    },
};



