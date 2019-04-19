function osform(obj) {
    this.id = obj.attr('id');
}

osform.prototype = {
    getData: function (evt) {
        var formData = {};
        var eltSelection = $("*[data-form~='" + this.id + "']");

        $.each(eltSelection, function (i, selection) {
            var object     = selection.getAttribute('data-objet');
            if (object != null && object.substring(object.length - 6, object.length) !== 'button') {
                var instance = new window[object]($(selection));
                var datas = instance.getData('');
                id = datas["id"];
                delete datas["id"];
                formData[id] = datas["value"];
            }
        });
        return formData;
    },
    setData: function (data) {
        var arrayData = datas.split("|");
        arrayData.each(function () {
            var id    = "";
            var value = "";
            var type  = "";

            dataObj = $(this).split("§");
            dataObj.each(function () {
                var pos = $(this).indexOf("=");
                var attr = $(this).substring(0, pos);

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

            var obj = $('#'+id);
            var evalString = "new "+obj.attr('data-objet')+'($("#'+obj.attr('id')+'#));';
            var instance = eval(evalString);
            var datas = instance.setData(value);
        })
    },
};