function odbutton(obj) {
    this.id     = obj.attr('id');
    var button  = obj.find('button');

    this.value  = button.data('value');
    this.form   = obj.data('form') ? obj.data('form') : '';
    this.objet  = obj.data('objet');
    this.datas  = obj.data();
}

odbutton.prototype = {
    getData: function (evt) {
        var valeur = this.value != undefined ? this.value : '';
        var chps = "id=" + this.id + "&value='" + valeur + "'" + "&event='" + evt + "'";
        chps = chps + "&object='" + this.objet + "'";

        if ( this.form.length > 0 ) {
            let formObj = new osform($('#'+this.form));
            let form    = formObj.getData(evt);
            chps        = chps + "&form='"+form+"'";
        }

        return chps;
    },
    setData: function (data) {
        this.value = data;
        $("#"+this.id).find('button').data('value', data);
    },
};