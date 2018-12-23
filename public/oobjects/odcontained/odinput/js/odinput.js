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
    validate: function() {
        var data    = this.value;
        var type    = this.type;
        var input   = $('#'+this.id+' input');
        var flag    = false;
        switch (type) {
            case 'text':
                var minlength = (input.attr('minlength') != undefined) ? input.attr('minlength'): -1;
                var maxlength = (input.attr('maxlength') != undefined) ? input.attr('maxlength'): -1;
                if (minlength != -1 || maxlength != -1 ) { // si tous 2 = -1 rien à faire, sinon test
                    var valueLength = this.value.length;
                    if (minlength <= valueLength && valueLength <= maxlength) {
                        flag = 'OK';
                    } else {
                        if (minlength >= valueLength) {
                            flag = 'KOLe champs doit comprendre '+minlength+' caractères minimum';
                        } else {
                            flag = 'KOLe champs doit comprendre '+maxlength+' caractères maximum';
                        }
                    }
                }
                return flag;
                break;
            case 'number':
                if ($.isNumeric(this.value)) {
                    flag = 'OK';
                } else {
                    flag = 'KOLe champs doit être numérique seulement';
                }
                break;
            case 'email':
                var email = this.value;
                if (email.match(/^\w+@[a-zA-Z_]+?\.[a-zA-Z]{2,3}$/)) {
                    flag = 'OK';
                } else {
                    flag = 'KOVeuillez saisir une adresse courriel (email) valide';
                }
                break;
            default:
                flag = 'KOErreur inconnue';
        }
        return flag;
    },
};
