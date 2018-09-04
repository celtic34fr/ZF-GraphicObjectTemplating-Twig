function odbutton(obj) {
    this.id     = obj.attr('id');
    let button  = obj.find('button');

    this.value  = button.data('value');
    this.form   = obj.data('form');
    this.data   = obj.data();
}

odbutton.prototype = {
    getData: function (evt) {
        let valeur = this.value != undefined ? this.value : '';
        let chps = "id=" + this.id + "&value='" + valeur + "'" + "&event='" + evt + "'";

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