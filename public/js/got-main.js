Storage.prototype.setObject = function (key, value) {
    this.setItem(key, JSON.stringify(value));
    console.log("setObject ",key, value);
};
Storage.prototype.getObject = function (key) {
    var value = this.getItem(key);
    console.log("getObject ",key, value);
    return value && JSON.parse(value);
};

function setZoneComm(key, value) {
    sessionStorage.setObject(key, value);
}

function getZoneComm(key) {
    return sessionStorage.getObject(key);
}

function updateZoneComm(key, value) {
    setZoneComm(key, value);
    $("#zone-comm").html(key);
}

function addZoneComm(code) {
    let key     = $("#zone-comm").html();
    let data    = getZoneComm(key);
    if (data != null && data.length > 0) {
        var url = new URL(code, window.location);
        url.searchParams.set("zoneComm", key);
        code = url.toString();
    }
    return code;
}

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
    let obj             = $("#"+idSource);
    if (event !== undefined && e !== undefined) {
        let dataKey     = event+'-stopevt';
        let stopEvent   = obj.data(dataKey);
        if (stopEvent === 'OUI' || stopEvent === undefined) {
            e.stopImmediatePropagation();
        }
    }
    // récupération de l’URL d’appel Ajax
    let urlGotCallback  = $("#gotcallback").text();

    let tabDatas        = [];
    let form            = $("#zone-comm").html();
    if (form.length === 0) {
        form            = obj.data('form') ? obj.data('form') : idSource;
    }
    // récupération et ajout si lieu de la zone de communication

    let zonComm         = getZoneComm(form);
    if (zonComm != null && !$.isEmptyObject(zonComm) ) {
        datas['zoneCommName'] = form;
        datas['zoneCommData'] = zonComm;
    }

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

        let updId       = "";
        let table       = "";
        let treeview    = "";
        let objectDOM   = undefined;
        if (id !== null && id.length > 0) { objectDOM   = $("#" + id); }
        let jQryObj     = "";
        switch (mode) {
            case 'rscs': //extraction des ressources CSS / Js avec injection
                loadResources(id, code);
                break;
            case "append": // ajout à un objet DOM existant
                if (objectDOM !== undefined) {
                    objectDOM.append(code);
                    if (objectDOM.find("#" + id + "Script").length > 0) {
                        $.globalEval($("#" + id + "Script").innerText);
                    }
                }
                break;
            case "appendAfter": // ajout à un objet DOM existant
                if (objectDOM !== undefined) {
                    objectDOM.after(code);
                    if (objectDOM.find("#" + id + "Script").length > 0) {
                        $.globalEval($("#" + id + "Script").innerText);
                    }
                }
                break;
            case "appendBefore": // ajout à un objet DOM existant
                if (objectDOM !== undefined) {
                    objectDOM.before(code);
                    if (objectDOM.find("#" + id + "Script").length > 0) {
                        $.globalEval($("#" + id + "Script").innerText);
                    }
                }
                break;
            case "update": // mise à jour, remplacement d’un objet DOM existant
                updId = "#" + id;
                $(updId).replaceWith(code);
                if (objectDOM !== undefined && objectDOM.find("#" + id + "Script").length > 0) {
                    $.globalEval($("#" + id + "Script").innerText);
                }
                break;
            case "innerUpdate": // remplacement du contenu d’un objet DOM
                if (objectDOM !== undefined) {
                    objectDOM.html(code);
                }
                break;
            case "raz": // vidage du contenu d’un objet DOM
                if (objectDOM !== undefined) {
                    objectDOM.html("");
                }
                break;
            case "delete": // suppression d’un objet DOM
                if (objectDOM !== undefined) {
                    objectDOM.remove();
                }
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
                id = parseInt(id); // delay d'attente pour exécution de la redirection
                code    = addZoneComm(code);
                setTimeout(function () {
                    $(location).attr('href', code);
                }, id );
                break;
            case "redirectBlank": // redirection HTML
                id = parseInt(id); // delay d'attente pour exécution de la redirection
                setTimeout(function () {
                    window.open(code, '_blank');
                }, id );
                break;
            case 'event': // format code : nomEvt|[OUI/NON]
                if (objectDOM !== undefined) {
                    let evt = code.substring(0, strpos(code, '|'));
                    let flg = code.substring(strpos(code, '|') + 1);
                    objectDOM.attr('data-' + evt + '-stopevt', flg);
                }
                break;
            case 'setData': // réaffectation valeur ou contenu associé à un objet
                if (objectDOM !== undefined) {
                    let objetJS = objectDOM.data('objet');
                    jQryObj = new window[objetJS](objectDOM);
                    if (jQryObj) {
                        jQryObj.setData(code);
                    }
                }
                break;
            case 'updZoneComm':
                updateZoneComm(id, code);
                break;
            default:
                if (objectDOM != undefined) {
                    let cls = objectDOM.data("objet");
                    jQryObj = new window[cls](objectDOM);
                    if (mode in jQryObj && typeof jQryObj[mode] == "function") {
                        jQryObj[mode](code); // TODO: Remove this check in production environment.
                    } else {
                        console.log(mode + " is not a function of not in " + cls);
                        console.log(jQryObj);
                    }
                }
        }
    });
    // mise à jour de la page pour faire voir ce qui est à voir + widthBT bien exprimé
    updatePage();
}

function loadResources(type, url) {
    let head    = document.getElementsByTagName('head')[0];
    let script  = '';
    switch(type) {
        case 'js' :
            script  = document.createElement('script');
            script.src  = location.protocol + "//" + location.host + "/" + url;
            script.async = false;
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
    if (widthbt !== undefined) {
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
    let require = '<p style="color:red;float:left;">*&nbsp;</p>';
    let topRequire = false;
    $('#'+formId+" .gotObject").each(function () {
        let id = $(this).attr('id');
        let obj = $("#"+id+" label:first");
        let htmlCode = obj.html();
        htmlCode = require + htmlCode;
        obj.html(htmlCode);
    })
}

function showHideTableNodata(id, nbrLines) {
    if (nbrLines < 1) {
        $("#"+id+" tr.line.nodata").removeClass('hide');
    } else {
        $("#"+id+" tr.line.nodata").removeClass('hide').addClass('hide');
    }
}

function getDPI(){
    return jQuery('#dpi').height();
}
