function odtreeview(obj) {
    this.id     = obj.attr('id');
    this.form   = obj.data('form');
    this.objet  = obj.data('objet');
    this.data   = obj.data();
}

odtreeview.prototype = {
    getData: function (evt) {
        let obj = $('#'+this.id);

        let selected = obj.find('li label span.check').map(function () {
            return String($(this).parent().parent().data('id'));
        }).get();
        let li = obj.children("div").children("ul").children("li");
        let tree = li.get().map(this.getNodeData, this);
        let value = {};
        value['selected'] = selected;
        value['tree']     = tree;
        return {id : this.id, value : value, object : this.objet, event : 'click'};
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' li[data-lvl="'+ value.lvl +'"]' +
                '[data-ord="'+ value.ord +'"]').addClass('selected');
        });
    },
    updtTreeLeaf: function(params) {
        let html        = params['html'];
        let selector    = params['selector'];
        $('#'+this.id+' '+selector).replaceWith(html);

    },
    appendTreeNode: function(params) {
        var html        = params['html'];
        var selector    = params['selector'];
        $('#'+this.id+' '+selector).append(html);
    },
    updateNodeState: function(currentInput) {
        var currentLi       = currentInput.parent('label').parent('li');
        var currentParent   = currentLi.parent('ul').parent('li');

        var nbreLi_Alls = 'rien';
        var nbreLiSelec = 'rien';
        var nbreLiIndet = 'rien';

//        updateStatusNode(currentParent);
    },
    getNodeData: function (domObj) {
        let obj = $(domObj);
        let id = String(obj.data("id"));
        let children = [];
        if (obj.hasClass("node")) {
            let domChildren = obj.children("ul").children("li");
            children = domChildren.get().map(this.getNodeData, this);
        }
        return {id: id, children: children};
    }
};

function parcoursLis(liItem, arrayTree) {
    var LIs = $('#'+liItem.attr('id')+' > ul > li');
    var arrayItrem  = Array();
    if (LIs.length > 0) {
        LIs.each(function () {
            arrayItrem.push($(this).attr("id"));
            if ($(this.selector+' > ul')) {
                var ret = parcoursLis($(this), arrayItrem)
            }
        });
        arrayTree.push(arrayItrem);
    }
    return arrayTree;
}

function initTreeview(idObject) {
    sortable('#'+idObject+' .t-sortable.sortable', {
        forcePlaceholderSize: true,
        placeholderClass: 'bg-navi border border-yellow',
        hoverClass: 'bg-maroon yellow',
        itemSerializer: function (item, container) {
            item.parent = '[parentNode]';
            item.node = '[Node]';
            item.html = item.html.replace('<', '&lt;');
            return item;
        },
        containerSerializer: function (container) {
            container.node = '[Node]';
            return container;
        }
    });

    sortable('#'+idObject+' .t-sortable-inner.sortable', {
        forcePlaceholderSize: true,
        items: ':not(.disabled)',
        placeholderClass: 'border border-maroon',
        hoverClass: 'bg-maroon yellow'
    });
}

function addBtnActionsTV(idObj) {
    var selector = '#' + idObj + ' li > div.btnActions';
    var nodes    = $(selector);
    $.each(nodes, function () {
        btnActions = $(this).data('btnactions');
        btnActions = btnActions.split('|');
        liNode     = $(this).parent('li');

        if ($(this).is(':empty')) {
            if (btnActions.length > 0 && btnActions[0].length > 0) {
                btnActions.forEach(function (btnName) {
                    var button = $('#' + idObj + 'BtnsAction #' + btnName)[0].outerHTML;
                    button = button.replace(btnName, liNode.data('id') + btnName);
                    liNode.find('> div.btnActions').append(button);
                });
            }
        }
    });
}

$(document).ready(function (evt) {

    $(document).on("sortupdate", '.gotObject[data-objet="odtreeview"] .t-sortable.sortable' , function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        var treeObj = Array();
        treeObj = parcoursLis($(".gotObject[data-objet='odtreeview']"), treeObj);
        // invokeAjax(treeObj, $(".gotObject[data-objet='odtreeview']").attr('id'), 'update', evt);
    });

    $(document).on("sortupdate", '.gotObject[data-objet="odtreeview"] .t-sortable-inner.sortable' , function(evt) {
        evt.preventDefault();
        evt.stopPropagation();
        var treeObj = Array();
        treeObj = parcoursLis($(".gotObject[data-objet='odtreeview']"), treeObj);
        // invokeAjax(treeObj, $('[data-objet=odtreeview]').attr('id'), 'update', evt);
    });

    $(document).on("click", '.gotObject.selectable[data-objet="odtreeview"] li:not(.unselect)' , function(evt) {
        evt.preventDefault();
        evt.stopPropagation();

        var idObject    = $(this).attr('id');
        idObject        = idObject.substr(0, idObject.indexOf('Li-'));
        var objectDOM   = $('#'+idObject);

        if ($(this).find('> label > span.odtcheck').hasClass('check')) {
            $(this).find('> label > span.odtcheck').removeClass('check');
        } else {
            if (objectDOM.data('multiselect') === false) {
                objectDOM.find('label span.odtcheck').removeClass('check');
            }
            $(this).find('> label > span.odtcheck').addClass('check');
        }

        var object          = new odtreeview(objectDOM);
        invokeAjax(object.getData('click'), idObject, 'click', evt);
    });
});
