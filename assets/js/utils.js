class CMUtils{

    static get CDN_path() {
        return "https://cdn.car-market.live/";
    }

    static getUrl() {
        var getUrl = window.location;
        var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
        if(baseUrl.slice(-1) == "/") baseUrl = baseUrl.slice(0, -1);
        return baseUrl;
    }

    static jsonize_form(selector) {
        var data = $(selector).serializeArray();
        var form_data = {};
        for( var i = 0; i < data.length; i++) {
            form_data[data[i].name] = data[i].value;
        }
        return form_data;
    }

    static insertData(selector, data) {
        var selectorData = $(selector).serializeArray();

        for(var i = 0; i < selectorData.length; i++){
             var selectorNameData = selectorData[i].name;
             $('*[name="'+selectorNameData+'"]').val(data[selectorNameData]);
        }
    }

    static goToProfile(id) {
        window.history.replaceState(null, null, "?id="+id);
        location.replace("#viewprofile");
    }

    static isLogged() {
        if(!localStorage.getItem("token")) {
            location.replace("#main");
            $("#loginModal").modal("show");
            return false;
        }
        return true;
    }

    static encodeQueryData(data) {
        const ret = [];

        for (let d in data)
            ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));

        return ret.join('&');
    }

}
