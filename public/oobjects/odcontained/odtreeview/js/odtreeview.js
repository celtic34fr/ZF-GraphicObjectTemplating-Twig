function odtreeview(obj) {
    this.id = obj.attr('id');
    this.form   = obj.data('form');
};

function updateNodeStatus(node) {
    let nbreLi_Alls = 'rien';
    let nbreLiSelec = 'rien';
    let nbreLiIndet = 'rien';

    if (node != undefined) {
        nbreLi_Alls = currentParent.children('ul').children('li').length;
        nbreLiSelec = currentParent.children('ul').children('li.selected').length;
        nbreLiIndet = currentParent.children('ul').children('li.indeterminate').length;
    } else {
        nbreLiUnSel = $('#'+this.id).children('ul').children('li').length;
        nbreLiSelec = $('#'+this.id).children('ul').children('li.selected').length;
        nbreLeSelec = $('#'+this.id).find('li.selected').length;
    }

    node.removeClass('selected').removeClass('indeterminate');
    if (nbreLi_Alls == nbreLiSelec) {
        node.addClass('selected');
        node.children('input').prop('checked', true).prop('indeterminate', false);
    } else if (nbreLiSelec > 0 || nbreLiIndet > 0) {
        node.addClass('indeterminate');
        node.children('input').prop('checked', false).prop('indeterminate', true);
    } else {
        node.children('input').prop('checked', false).prop('indeterminate', false);
    }

    if (node != udefined) {
        updateNodeStatus(node.parent('ul').parent('li'));
    }
};

odtreeview.prototype = {
    getData: function (evt) {
        let selected = [];
        $('#'+this.id+' li.selected').each(function () {
            selected.push($(this).find('input').data('id'));
        });
        let chps = "id=" + this.id + "&value='" + selected.join("$") + "'&event='click'";
        return chps;
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' li[data-lvl="'+ value.lvl +'"][data-ord="'+ value.ord +'"]').addClass('selected');
        });
    },
    updtTreeLeaf(params) {
        let html        = params['html'];
        let selector    = params['selector'];
        $('#'+this.id+' '+selector).replaceWith(html);

    },
    appendTreeNode(params) {
        let html        = params['html'];
        let selector    = params['selector'];
        $('#'+this.id+' '+selector).append(html);
    },
    updateNodeState(currentInput) {
        let currentLi       = currentInput.parent('label').parent('li');
        let currentParent   = currentLi.parent('ul').parent('li');

        let nbreLi_Alls = 'rien';
        let nbreLiSelec = 'rien';
        let nbreLiIndet = 'rien';

//        updateStatusNode(currentParent);

    }
};