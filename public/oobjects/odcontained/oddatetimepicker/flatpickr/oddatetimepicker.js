function oddatetimepicker(obj) {
    this.id     = obj.attr('id');
    this.value  = obj.find('input').val();
    this.form   = obj.data('form');
    this.data   = obj.data();
}

oddatetimepicker.prototype = {
    getData: function (evt) {
        var valeur = (this.value != undefined) ? this.value : '';
        var chps = "id=" + this.id + "&value='" + valeur + "'" + "&event='" + evt + "'";
        chps = chps + "&object='"+this.data('objet')+"'";
        return chps;
    },
    setData: function (data) {
        this.value = data;
        $("#"+this.id).find('input').val(data);
    },
};
