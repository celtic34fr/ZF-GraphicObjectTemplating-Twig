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

function setAutoColsWidth(idObj) {
    var selector    = '#' + idObj + ' table';
    var table       = $(selector);
    var ths         = table.find("tr:first th");
    var cssWidth    = 0;

    // console.log(ths);

    var allRules = [];
    var sSheetList = document.styleSheets;
    var colsRule   = [];

    for (var i = 0; i < ths.length; i++) {
        var thClass = ths[i].className;
        thClass     = '.'+thClass.substring(4);
        // console.log(thClass);
        for (var sSheet = 0; sSheet < sSheetList.length; sSheet++) {
            var ruleList = document.styleSheets[sSheet].cssRules;
            for (var rule = 0; rule < ruleList.length; rule ++) {
                var ruleSelector = ruleList[rule].selectorText;
                if (ruleSelector != undefined) {
                    // console.log(ruleSelector.indexOf(thClass));
                    if (ruleSelector.indexOf(thClass) > -1) {
                        cssWidth += parseInt(ruleList[rule].style.width);
                        colsRule.push(thClass);
                    }
                }
            }
        }
    }

    console.log( 'Width par CSS : '+cssWidth );
    console.log( 'cols avec CSS : '+colsRule );

    var elmnt       = document.getElementById(idObj);
    console.log(elmnt);

    var table       = elmnt.getElementsByTagName('table');
    console.log(table[0]);
    // console.log(table[0].clientWidth);
    console.log(table[0].width);

    var tableWidth  = table[0].clientWidth + 1;
    var restWidth   = tableWidth - ths.length - 1 - cssWidth;
    var autoWidth   = restWidth /(ths.length - colsRule.length);

    // var objet = $("#{{ objet.id }}");
    // console.log(objet.width());
    // console.log($( document ).find("#{{ objet.id }}").width());
    // console.log(restWidth);
    // console.log('nbre total de colonnes : '+ths.length);
    // console.log('nbre css pour colonnes : '+colsRule.length);
    // console.log('autoWidth = '+(restWidth /(ths.length - colsRule.length)));

    var baseSelector = selector+" .col";
    for (var i = 0; i < ths.length; i++) {
        var thClass = ths[i].className;
        thClass     = '.'+thClass.substring(4);
        // console.log($.inArray(thClass, colsRule) > -1);
        if ($.inArray(thClass, colsRule) < 0) {
            $(baseSelector+thClass).addClass('autoWidth');
        }
    }
    if (autoWidth > 0) {
        $(baseSelector+".autoWidth").css("width", autoWidth+'px')
    }
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



