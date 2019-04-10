function odselect(obj) {
    this.id     = obj.attr('id');
    this.form   = obj.data('form');
    this.objet  = obj.data('objet');
    this.data   = obj.data();
}

odselect.prototype = {
    getData: function (evt) {
        var selected = '';
        $('#'+this.id+' option:selected').each(function () { selected += $(this).val() + "-" });
        selected = selected.substring(0, selected.length - 1);
        var chps = "id=" + this.id + "&value='" + selected + "'&event='change'";
        chps = chps + "&object='" + this.objet + "'";
        return chps;
    },
    setData: function (data) {
        $.each(data, function (i, value) {
            $('#'+this.id+' option[value='+value+']').attr('selected','selected');
        });
    },
};

jQuery(document).ready(function (evt) {
    // si il existe au moins un bouton avec callback
    if ($(".gotObject.selectChg").length > 0 ) {
        $(".gotObject.selectChg").on('change', function (evt) {
            let objet = new odselect($(this));
            var invalid = "";
            if (typeof objet.invalidate === "function") { invalid = objet.invalidate(); }
            if (invalid.length == 0) {
                $(this).remove("has-error");
                $(this).find("span").removeClass("hidden").addClass("hidden");
                invokeAjax(objet.getData("click"), $(this).attr("id"), "click", evt);
            } else {
                $(this).remove("has-error").addClass("has-error");
                $(this).find("span").removeClass("hidden").html(invalid);
            }
        });
    }
});
