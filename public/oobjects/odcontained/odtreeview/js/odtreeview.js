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
            return ($(this).parent().parent().data('id'));
        }).get();
        let li = obj.children("div").children("ul").children("li");
        let tree = li.get().map(this.getNodeData, this);
//        console.log(tree);
        let value = {};
        value['selected'] = selected;
        value['tree']     = tree;
        return "id=" + this.id +
            "&value='" + JSON.stringify(value) + "'" +
            "&event='click'&object='" + this.objet + "'";
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
        let id = obj.data("id");
        let a = [];
        if (obj.hasClass("node")) {
            let children = obj.children("ul").children("li");
            a = children.get().map(this.getNodeData, this);
        }
        ret = Object();
        ret[id] = a;
        return ret;
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

sortable('#{{ objet.id }} .t-sortable.sortable', {
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
    },
});

sortable('.t-sortable-inner.sortable', {
    forcePlaceholderSize: true,
    items: ':not(.disabled)',
    placeholderClass: 'border border-maroon',
    hoverClass: 'bg-maroon yellow',
});

$(document).ready(function (evt) {
    if ($(".gotObject[data-objet='odtreeview'] .t-sortable.sortable").length > 0) {
        $(".gotObject[data-objet='odtreeview'] .t-sortable.sortable").on("sortupdate", function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var treeObj = Array();
            treeObj = parcoursLis($(".gotObject[data-objet='odtreeview']"), treeObj);
            // invokeAjax(treeObj, $(".gotObject[data-objet='odtreeview']").attr('id'), 'update', evt);
        });
    }

    if ($(".gotObject[data-objet='odtreeview'] .t-sortable.sortable").length > 0) {
        $(".gotObject[data-objet='odtreeview'] .t-sortable-inner.sortable").on("sortupdate", function (evt) {
            evt.preventDefault();
            evt.stopPropagation();
            var treeObj = Array();
            treeObj = parcoursLis($(".gotObject[data-objet='odtreeview']"), treeObj);
            // invokeAjax(treeObj, $('[data-objet=odtreeview]').attr('id'), 'update', evt);
        });
    }
});

