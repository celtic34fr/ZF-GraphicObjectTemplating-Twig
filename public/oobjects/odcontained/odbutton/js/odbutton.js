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
        let valeur = this.value !== undefined ? this.value : '';
        switch (valeur) {
            case 'odtreeview':
                valeur = $('#' + this.id).closest("li").data("id");
                this.id    = this.id.substr(valeur.toString().length);
                break;
            case 'odtable':
                valeur = $('#' + this.id).closest("tr").data("lno");
                this.id    = this.id.substr(valeur.toString().length);
                valeur     = 'L' + valeur + 'C'+ $('#'+this.id).closest("td").data("cno");
                break;
            default:
        }

        let form = [];
        if ( this.form.length > 0 ) {
            let formObj = new osform($('#'+this.form));
            form = formObj.getData(evt);
        }

        // return chps;
        return {id: this.id, value : valeur, event : evt, object : this.objet, form: form};
    },
    setData: function (data) {
        this.value = data;
        $("#"+this.id).find('button').data('value', data);
    },
};

// jQuery(document).ready(function (evt) {
//     // si il existe au moins un bouton avec callback
//     if ($(".gotObject.btnCback[data-objet='odbutton']").length > 0 ) {
//         $(document).on("click", ".gotObject.btnCback[data-objet='odbutton']", function (evt) {
//             let objet = new odbutton($(this));
//             var invalid = "";
//             if (typeof objet.invalidate === "function") {
//                 invalid = objet.invalidate();
//             }
//             if (invalid.length == 0) {
//                 $(this).remove("has-error");
//                 $(this).find("span").removeClass("hidden").addClass("hidden");
//                 invokeAjax(objet.getData("click"), $(this).attr("id"), "click", evt);
//             } else {
//                 $(this).remove("has-error").addClass("has-error");
//                 $(this).find("span").removeClass("hidden").html(invalid);
//             }
//         });
//     }
// });
