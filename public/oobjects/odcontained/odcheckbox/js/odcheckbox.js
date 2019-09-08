function odcheckbox(obj) {
    this.id = obj.attr('id');
    this.options = [];
    let type = obj.find("input");
    if (type.length > 0) {
        let options = [];
        type.each(function(){
            if ($(this).is(':checked')) {
                options.push($(this).val());
            }
        });
        this.options = options;
    }
    this.objet  = obj.data('objet');
    this.data = obj.data();
}

odcheckbox.prototype = {
    getData: function (evt) {
        // let chps = "id=" + this.id;
        // chps = chps + "&value='" + this.options.join("$") + "'";
        // chps = chps + "&evt='" + evt + "'";
        // chps = chps + "&obj='OUI'";
        // chps = chps + "&object='" + this.objet + "'";
        // return chps;
        return {id : this.id, value: this.options.join("$"), event: evt, object : this.objet};
    },
    setData: function (data) {
        if (data === "") { // raz des options sélectionnées
            $("#"+this.id+" option").removeAttr("selected");
            this.options = [];
        } else  {
            if ($.isArray(data)) {
                data.each(function(idx, val){
                    $("#"+this.id+" option:nth_child("+val+")").attr("selected","selected");
                    $this.options.push(val);
                })
            }
        }
    },
};


jQuery(document).ready(function (evt) {

    $(document).on("change", ".gotObject.checkboxCback[data-objet='odcheckbox']", function (evt) {
        let objet = new odcheckbox($(this));
        let invalid = "";
        if (typeof objet.invalidate === "function") { invalid = objet.invalidate(); }
        if (invalid.length === 0) {
            $(this).remove("has-error");
            $(this).find("span").removeClass("hidden").addClass("hidden");
            invokeAjax(objet.getData("click"), $(this).attr("id"), "click", evt);
        } else {
            $(this).remove("has-error").addClass("has-error");
            $(this).find("span").removeClass("hidden").html(invalid);
        }
    });

});
