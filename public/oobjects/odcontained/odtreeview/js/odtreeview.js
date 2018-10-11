function odtreeview(obj) {
    this.id = obj.attr('id');
    this.form   = obj.data('form');
}

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
        console.log('current >'+currentLi.attr('id'));
        console.log('parent >'+currentParent.attr('id'));

        let nbreLiUnSel = 'rien';
        let nbreLiSelec = 'rien';
        let nbreLeSelec = 'rien';
        if (currentParent.length > 0) {
            nbreLiUnSel = currentParent.children('ul').children('li').length;
            nbreLiSelec = currentParent.children('ul').children('li.selected').length;
            nbreLeSelec = currentParent.find('li.selected').length;
        } else {
            nbreLiUnSel = $('#'+this.id).children('ul').children('li').length;
            nbreLiSelec = $('#'+this.id).children('ul').children('li.selected').length;
            nbreLeSelec = $('#'+this.id).find('li.selected').length;
        }
        console.log('nbre li child  >'+nbreLiUnSel);
        console.log('nbre li Select >'+nbreLiSelec);
        console.log('nbre le Select >'+nbreLeSelec);
    }
};