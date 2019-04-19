function odcaptcha(obj) {
    this.id     = obj.attr('id');
    this.val    = obj.find('input').val();
    this.form   = obj.data('form') ? obj.data('form') : '';
    this.objet  = obj.data('objet');
    this.data   = obj.data();
}

odcaptcha.prototype = {
    getData: function (evt) {
        var valeur = this.val != undefined ? this.val : '';
        // var chps = "id=" + this.id + "&value='" + valeur + "'" + "&event='" + evt + "'";
        // chps = chps + "&object='" + this.objet + "'";
        // return chps;
        return {id : this.id, value: valeur, event: evt, object : this.objet};
    },
    setData: function (data) {
        this.value = data;
        $("#"+this.id).find('input').data('value', data);
    },
};