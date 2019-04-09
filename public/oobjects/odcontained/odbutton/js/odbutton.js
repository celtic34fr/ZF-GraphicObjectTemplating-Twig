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

jQuery(document).ready(function (evt) {
    // si il existe au moins un bouton avec callback
    if ($('.gotObject.btnCback').length > 0 ) {
        $('.gotObject.btnCback').on('click', function (evt) {
            let objet = new odbutton($(this));
            var invalid = '';
            if (typeof objet.invalidate === 'function') {
                invalid = objet.invalidate();
            }
            if (invalid.length == 0) {
                $(this).remove('has-error');
                $(this).find('span').removeClass('hidden').addClass('hidden');
                invokeAjax(objet.getData('click'), $(this).attr('id'), 'click', evt);
            } else {
                $(this).remove('has-error').addClass('has-error');
                $(this).find('span').removeClass('hidden').html(invalid);
            }
        });
    }
});
