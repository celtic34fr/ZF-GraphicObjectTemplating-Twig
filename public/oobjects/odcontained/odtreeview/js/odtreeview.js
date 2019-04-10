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

$(document).ready(function (evt) {

    sortable('.gotObject[data-objet="odtreeview"] .t-sortable.sortable', {
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

    sortable('.gotObject[data-objet="odtreeview"] .t-sortable-inner.sortable', {
        forcePlaceholderSize: true,
        items: ':not(.disabled)',
        placeholderClass: 'border border-maroon',
        hoverClass: 'bg-maroon yellow',
    });

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

        if ($(this).find('> label > span.odtcheck').hasClass('check')) {
            $(this).find('> label > span.odtcheck').removeClass('check');
        } else {
            var idObject    = $(this).attr('id');
            idObject        = idObject.substr(0, idObject.indexOf('Li-'));
            var objectDOM   = $('#'+idObject);
            if (objectDOM.data('multiselect') == 'false') {
                objectDOM.find('label span.odtcheck').removeClass('check');
            }
            $(this).find('> label > span.odtcheck').addClass('check');
        }

        var object          = new odtreeview(objectDOM);
        invokeAjax(object.getData('click'), idObject, 'click', evt);
    });
});
