function osform(obj) {
    this.id = obj.attr('id');
}

osform.prototype = {
    getData: function (evt) {
        let formData = {};
        let eltSelection = $("*[data-form~='" + this.id + "']");

        $.each(eltSelection, function (i, selection) {
            let object     = selection.getAttribute('data-objet');
            if (object != null && object.substring(object.length - 6, object.length) !== 'button') {
                let instance = new window[object]($(selection));
                let datas = instance.getData('');
                let id = datas["id"];
                delete datas["id"];
                formData[id] = datas["value"];
            }
        });
        return formData;
    },
    setData: function (data) {
        let arrayData = datas.split("|");
        arrayData.each(function () {
            let id    = "";
            let value = "";
            let type  = "";

            let dataObj = $(this).split("§");
            dataObj.each(function () {
                let pos = $(this).indexOf("=");
                let attr = $(this).substring(0, pos);

                switch (attr) {
                    case "id":
                        id = $(this).substring(pos +1);
                        break;
                    case "value":
                        value = $(this).substring(pos +1);
                        break;
                    case "type":
                        type = $(this).substring(pos +1);
                        break;
                }
            });

            let obj = $('#'+id);
            let evalString = "new "+obj.attr('data-objet')+'($("#'+obj.attr('id')+'#));';
            let instance = eval(evalString);
            let datas = instance.setData(value);
        })
    },
};