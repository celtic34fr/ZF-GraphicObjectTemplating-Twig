function odradio(obj) {
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

odradio.prototype = {
    getData: function (evt) {
        return {id : this.id, value: this.options.join("$"), event: evt, object : this.objet};
    },
    setData: function (data) {

    },
};