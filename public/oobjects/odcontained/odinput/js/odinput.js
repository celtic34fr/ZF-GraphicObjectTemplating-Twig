function odinput(obj) {
    this.id     = obj.attr('id');
    this.value  = obj.find('input').val();
    this.type   = obj.find('input').attr('type');
    this.form   = obj.find('input').data('form');
    this.data   = obj.data();
}

odinput.prototype = {
    getData: function (evt) {
        var valeur = (this.value != undefined) ? this.value : '';
        var chps = "id=" + this.id + "&value='" + valeur + "'" + "&event='" + evt + "'";
        return chps;
    },
    setData: function (data) {
        this.value = data;
        $("#"+this.id).find('input').val(data);
    },
    invalidate: function() {
        // ------------------------------------------------------
        // méthode de validation / invalidation du champ ODInput
        // si retour un champ vide  = champ valide
        // sinon retourne le message d'erreur
        // ------------------------------------------------------
        var data    = this.value;
        var type    = this.type;
        var input   = $('#'+this.id+' input');
        var retour  = '';
        switch (type) {
            case 'hidden':
                break;
            case 'text':
                if (this.data('mask') != undefined && this.data('mask').length > 0) {
                    break;
                }
            case 'password':
                var minlength = (input.attr('minlength') != undefined) ? input.attr('minlength'): -1;
                var maxlength = (input.attr('maxlength') != undefined) ? input.attr('maxlength'): -1;
                if (minlength != -1 || maxlength != -1 ) { // si tous 2 = -1 rien à faire, sinon test
                    var valueLength = this.value.length;
                    if (!(minlength <= valueLength && valueLength <= maxlength)) {
                        if (minlength >= valueLength) {
                            retour = 'Le champs doit comprendre '+minlength+' caractères minimum';
                        } else {
                            retour = 'Le champs doit comprendre '+maxlength+' caractères maximum';
                        }
                    }
                }
                break;
            case 'number':
                if (!$.isNumeric(this.value)) {
                    retour = 'Le champs doit être numérique seulement';
                } else {
                    var valMin = (this.data('valMin') != undefined) ? this.data('valMin') : '';
                    var valMax = (this.data('valMax') != undefined) ? this.data('valMax') : '';
                    if ($.isNumeric(valMin) && this.value < valMin) {
                        retour = 'La valeur doit être au moins égale à '+valMin;
                    }
                    if (retour.length == 0 && $.isNumeric(valMax) && this.value > valMax) {
                        retour = 'La valeur doit être au maximum égale à '+valMax;
                    }
                }
                break;
            case 'email':
                var email = this.value;
                if (!email.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
                    retour = 'Veuillez saisir une adresse courriel (email) valide';
                }
                break;
            default:
                retour = 'Erreur inconnue';
        }
        return retour;
    },
};
