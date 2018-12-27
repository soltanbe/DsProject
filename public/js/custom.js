$( document ).ready(function() {
    App.onLoad();
});
const App={
    onLoad:function () {
        this.getAllDataOfUser();

    },
    getAllDataOfUser:function () {
        $.ajax({
            url: 'getAllDataOfUser',
            data: {},
            method: 'GET',
            dataType: 'JSON',
            success: function (data) {
                if(data['status']=='success'){
                    $('#name').text(data.data.name);
                    $('#brithday').text(data.data.brithday);
                    $('#hobbies').html(Helper.prepareList('hobbies',data.data.hobbies));
                    $('#frinds').html(Helper.prepareList('frinds',data.data.frinds));
                    $('#other').html(Helper.prepareList('other',data.data.other));
                    $('.addFrind').unbind().on('click',function (e) {
                        e.preventDefault();
                        let frind_id=$(this).attr('data-id');
                        let csrf_token=$('meta[name="csrf-token"]').attr('content');
                        Swal({
                            title: 'Are you sure?',
                            text: "u will delete last friend ' max friend 5",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, add friend!'
                        }).then(function(result) {
                            if (result.value) {
                                $.ajax({
                                    url: 'addFriend',
                                    data: {frind_id:frind_id, "_token": csrf_token},
                                    method: 'POST',
                                    dataType: 'JSON',
                                    success: function (data) {
                                        if(data['status']=='success'){
                                            App.getAllDataOfUser();
                                        }else{

                                        }
                                    }
                                });
                            }
                        })
                    });
                    $('.deleteFrind').unbind().on('click',function (e) {
                        e.preventDefault();
                        let frind_id=$(this).attr('data-id');
                        let csrf_token=$('meta[name="csrf-token"]').attr('content');
                        Swal({
                            title: 'Are you sure?',
                            text: "u will delete frind",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete frind!'
                        }).then(function(result) {
                            if (result.value) {
                                $.ajax({
                                    url: 'deleteFriend',
                                    data: {frind_id:frind_id, "_token": csrf_token},
                                    method: 'POST',
                                    dataType: 'JSON',
                                    success: function (data) {
                                        if(data['status']=='success'){
                                            App.getAllDataOfUser();
                                        }
                                    }
                                });
                            }
                        })
                    });
                }
            }
        });


    },



}