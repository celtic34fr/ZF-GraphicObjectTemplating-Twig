function odcolorpicker(obj) {
    this.id = obj.attr('id');
    this.form   = obj.data('form') ? obj.data('form') : '';
    this.objet  = obj.data('objet');
}

odcolorpicker.prototype = {
    getData: function (evt) {
        let val = $("#"+this.id+"Input").colorpicker("val");
        return {id: this.id, value : val, event : evt, object : this.objet, form: this.form};
    },
    setData: function (data) {

    },
};