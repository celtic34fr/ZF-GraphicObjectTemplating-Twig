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
        let tree = li.get().map(function (elem) {
            return this.getNodeData(elem)
        }, this);
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
