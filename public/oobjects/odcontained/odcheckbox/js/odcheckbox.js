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
    this.data = obj.data();
}

odcheckbox.prototype = {
    getData: function (evt) {
        let chps = "id=" + this.id;
        chps = chps + "&value='" + this.options.join("$") + "'";
        chps = chps + "&evt='" + evt + "'";
        chps = chps + "&obj='OUI'";
        chps = chps + "&object='"+this.data('objet')+"'";
        return chps;
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