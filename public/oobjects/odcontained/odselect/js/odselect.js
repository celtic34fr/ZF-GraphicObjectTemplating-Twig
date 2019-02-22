function odselect(obj) {
    this.id     = obj.attr('id');
    this.form   = obj.data('form');
}

odselect.prototype = {
    getData: function (evt) {
        var selected = '';
        $('#'+this.id+' option:selected').each(function () {
            selected += $(this).val() + "-"
        });
        selected = selected.substring(0, selected.length - 1);
        var chps = "id=" + this.id + "&value='" + selected + "'&event='change'";
        chps = chps + "&object='"+this.data('objet')+"'";
        return chps;
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' option[value='+value+']').attr('selected','selected');
        });
    },
};