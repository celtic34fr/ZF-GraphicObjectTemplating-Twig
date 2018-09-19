function odselect(obj) {
    this.id     = obj.attr('id');
    this.form   = obj.data('form');
}

odselect.prototype = {
    getData: function (evt) {
        let selected = '';
        $('#'+this.id+' option:selected').each(function () {
            selected += $(this).val() + "-"
        });
        let chps = "id=" + this.id + "&value='" + selected + "'&event='change'";
        return chps;
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' option[value='+value+']').attr('selected','selected');
        });
    },
};