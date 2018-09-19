/**
 * méthode invokeAjax
 * @param datas     -> ensemble des données à communiquer à la callback appelé
 * @param idSource  -> identifiant de l'objet appelalnt
 * @param event     -> événement déclenchant
 * @param e         -> objet Event (js)
 *
 * appel du module de gestion des appels aux callbacks
 */

function invokeAjax(datas, idSource, event, e) {
    // vérification propagation événement
    if (event !== undefined) {
        let dataKey   = event+'-stopevt';
        let stopEvent = $('#'+idSource).data(dataKey);
        if (stopEvent === 'OUI' || stopEvent === undefined) {
            e.stopImmediatePropagation();
        }
    }
    // récupération de l’URL d’appel Ajax
    let urlGotCallback = $("#gotcallback").html();
    let tabDatas       = [];
    $.ajax({
        url:        urlGotCallback,
        type:       'POST',
        dataType:   'json',
        async:      false,
        data:       datas,

        success: function (returnDatas, status) {
            tabDatas = returnDatas;
        },

        error : function(xhr, textStatus, errorThrown) {
            if (xhr.status === 0) {
                alert('Not connected. Verify Network.');
            } else if (xhr.status === 404) {
                alert('Requested page not found. [404]');
            } else if (xhr.status === 500) {
                alert('Server Error [500].');
            } else if (errorThrown === 'parsererror') {
                alert('Requested JSON parse failed.');
            } else if (errorThrown === 'timeout') {
                alert('Time out error.');
            } else if (errorThrown === 'abort') {
                alert('Ajax request aborted.');
            } else {
                alert('Remote sever unavailable. Please try later, '+xhr.status+"//"+errorThrown+"//"+textStatus);
            }
        }
    });

    // traitement du tableau des retours d’exécution de callback
    $.each(tabDatas, function (i, ret) {
        let id   = "";
        let mode = "";
        let code = "";
        $.each(ret, function (j, k) {
            switch (j) {
                case 'id':
                    id = k;
                    break;
                case 'mode':
                    mode = k;
                    break;
                case 'code':
                    code = k;
                    break;
            }
        });

        let updId = "";
        let table = "";
        switch (mode) {
            case 'rscs': //extraction des ressources CSS / Js avec injection
                loadResources(id, code);
                break;
            case "append": // ajout à un objet DOM existant
                $("#" + id).append(code);
                if ($("#" + id).find("#" + id + "Script").length > 0) {
                    $.globalEval($("#" + id + "Script").innerText);
                    updatePage();
                }
                break;
            case "appendAfter": // ajout à un objet DOM existant
                $("#" + id).after(code);
                if ($("#" + id).find("#" + id + "Script").length > 0) {
                    $.globalEval($("#" + id + "Script").innerText);
                    updatePage();
                }
                break;
            case "appendBefore": // ajout à un objet DOM existant
                $("#" + id).before(code);
                if ($("#" + id).find("#" + id + "Script").length > 0) {
                    $.globalEval($("#" + id + "Script").innerText);
                    updatePage();
                }
                break;
            case "update": // mise à jour, remplacement d’un objet DOM existant
                updId = "#" + id;
                $(updId).replaceWith(code);
                updatePage();
                break;
            case "innerUpdate": // remplacement du contenu d’un objet DOM
                updId = "#" + id;
                $(updId).html(code);
                updatePage();
                break;
            case "raz": // vidage du contenu d’un objet DOM
                $("#" + id).html("");
                break;
            case "delete": // suppression d’un objet DOM
                $("#" + id).remove();
                break;
            case "exec": // exécution de code JavaScript contenu dans une chaîne de caracrtères
                $.globalEval(code);
                break;
            case "execID": // exécution de code JavaScript contenu dans un objet DOM
                let objet = $("#"+code);
                let script = objet.html();
                $.globalEval(script);
                break;
            case "redirect": // redirection HTML
                id = parseInt(id); // delay d'attente pour exécution de la resirection
                setTimeout(function () {
                    $(location).attr('href', code);
                }, id );
                break;
            case 'event': // format code : nomEvt|[OUI/NON]
                let evt = code.substring(0, strpos(code, '|'));
                let flg = code.substring(strpos(code, '|') + 1);
                $('#'+id).attr('data-'+evt+'-stopevt', flg);
                break;
            case 'updCols': // mise à jour colonne ODTable
                table = new odtable($('#'+id));
                table.updateCol(code);
                break;
            case 'rmLineUpd': // mise à jour colonne ODTable
                table = new odtable($('#'+id));
                table.rmLineUpdate(code);
                break;
        }
    });
}

function loadResources(type, url) {
    let head    = document.getElementsByTagName('head')[0];
    let script  = '';
    switch(type) {
        case 'js' :
            script  = document.createElement('script');
            script.src  = location.protocol + "//" + location.host + "/" + url;
            break;
        case 'css' :
            script  = document.createElement('link');
            script.type = 'text/css';
            script.rel  = 'stylesheet';
            script.href = location.protocol + "//" + location.host + "/" + url;
            break;
    }
    script.onload = function () {
        console.log(url + ' loaded');
        eval(script);
    };
    head.append(script);
}

function buildBootstrapClasses(widthbt) {
    let btClasses = '';
    if (widthbt != undefined) {
        widthbt = widthbt.split(':');
        $.each(widthbt, function (idx, val) {
            let typs = val.substring(0,2);
            let cols = val.substring(2);
            switch (typs) {
                case "WL" :
                    btClasses = btClasses + 'col-lg-' + cols + ' '; break;
                case "WM" :
                    btClasses = btClasses + 'col-md-' + cols + ' '; break;
                case "WS" :
                    btClasses = btClasses + 'col-sm-' + cols + ' '; break;
                case "WX" :
                    btClasses = btClasses + 'col-xs-' + cols + ' '; break;
                case "OL" :
                    btClasses = btClasses +'col-lg-offset-' + cols + ' '; break;
                case "OM" :
                    btClasses = btClasses + 'col-md-offset-' + cols + ' '; break;
                case "OS" :
                    btClasses = btClasses + 'col-sm-offset-' + cols + ' '; break;
                case "OX" :
                    btClasses = btClasses + 'col-xs-offset-' + cols + ' '; break;
            }
        });
    }
    return btClasses;
}

function setBtClasses(selector, btParms) {
    let btClasses = buildBootstrapClasses(btParms);
    $(selector).addClass(btClasses);
}

function updatePage() {
    $(".gotObject").each(function () {
        let widthbtparm = $(this).data("widthbt");
        let btClass = buildBootstrapClasses(widthbtparm);
        $(this).addClass(btClass);
        $(this).removeClass('hidden');
    });
}

function updateForm(formId) {
    let require = '<p style="color:red;float:left;";>*&nbsp;</p>';
    let topRequire = false;
    $('#'+formId+" .gotObject").each(function () {
        let id = $(this).attr('id');
        let htmlCode = $("#"+id+" label:first").html();
        htmlCode = require + htmlCode;
        $("#"+id+" label:first").html(htmlCode);
    })
}


function showHideTableNodata(id, nbrLines) {
    if (nbrLines < 1) {
        $("#"+id+" tr.line.nodata").removeClass('hide');
    } else {
        $("#"+id+" tr.line.nodata").removeClass('hide').addClass('hide');
    }
}
