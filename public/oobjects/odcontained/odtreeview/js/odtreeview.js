function odtreeview(obj) {
    this.id = obj.attr('id');
    this.form   = obj.data('form');
}

odtreeview.prototype = {
    getData: function (evt) {
        let selected = '';
        $('#'+this.id+' li.selected').each(function () {
            selected += $(this).data('lvl') + '.' + $(this).data('ord') + "-"
        });
        selected = selected.substring(0, selected.length - 1);
        let chps = "id=" + this.id + "&value='" + selected + "'&event='click'";
        return chps;
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' li[data-lvl="'+ value.lvl +'"][data-ord="'+ value.ord +'"]').addClass('selected');
        });
    },
};