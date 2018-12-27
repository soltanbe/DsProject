const Helper={
    getRequest:function (url,params,callback) {
        $.ajax({
            url: url,
            data:data,
            method:'GET',
            dataType:'JSON',
            success: callback(data)
        });
    },
    prepareList:function (type,dataList) {
        let Html='<ul class="list-group">';
        switch (type){
            case 'hobbies':
                dataList.forEach(function (h) {
                    Html+='<li class="list-group-item">'+h+'</li>'
                });
                break;
            case 'frinds':
                dataList.forEach(function (h) {
                    Html+='<li class="list-group-item">' +
                        '<div class="col-md-6">'+
                        h.name +
                        '</div>'+
                         '<div class="col-md-6">' +
                        '<button class="btn btn-danger deleteFrind" data-id="'+h.id+'">Delete Freind<i class="fa fa-minus"></i></button>'+
                    '</div></li>'
                });
                break;
            case 'other':
                dataList.forEach(function (h) {
                    Html+='<li class="list-group-item">' +
                        '<div class="col-md-6">'+
                        h.name +
                        '</div>'+
                        '<div class="col-md-6">' +
                        '<button class="btn btn-success addFrind" data-id="'+h.id+'">Add Freind<i class="fa fa-plus"></i></button>'+
                        '</div></li>'
                });

                break;
            case 'showAllFriends':
                dataList.forEach(function (h) {
                    Html+='<li class="list-group-item">' +
                        '<div class="col-md-3">'+
                        h.name +
                        '</div>'+
                        '<div class="col-md-3">'+
                        h.brithday +
                        '</div>'+
                        '<div class="col-md-3">'+
                        h.email +
                        '</div>'+
                        '<div class="col-md-3">'+
                        h.username +
                        '</div>';

                });
                break;
                case 'showUpcomingBrithdays':
                case 'showPotenialFriends':
                dataList.forEach(function (h) {
                    Html+='<li class="list-group-item">' +
                        '<div class="col-md-3">'+
                        h.name +
                        '</div>'+
                        '<div class="col-md-3">'+
                        h.brithday1 +
                        '</div>';
                });
                break;
        }


        Html+='<ul>';
        return Html;

    }

}