$( document ).ready(function() {
    App.onLoad();
});
const App={
    onLoad:function () {
        this.getAllDataOfUser();
        $('#show_all_friends').on('click',function () {
            let csrf_token=$('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'showAllFriends',
                data: {"_token": csrf_token},
                method: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if(data['status']=='success'){
                        $('#action_data').html(Helper.prepareList('showAllFriends',data.data));
                        $('#action_name').text('show All Friends');

                    }else{

                    }
                }
            });
        })
        $('#show_brithdays').on('click',function () {
            let csrf_token=$('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'showBrithdays',
                data: {"_token": csrf_token},
                method: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if(data['status']=='success'){
                        $('#action_data').html(Helper.prepareList('showBrithdays',data.data));
                        $('#action_name').text('show Brithdays');

                    }else{

                    }
                }
            });
        })
        $('#show_potenial_friends').on('click',function () {
            let csrf_token=$('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'showPotenialFriends',
                data: {"_token": csrf_token},
                method: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if(data['status']=='success'){
                        $('#action_data').html(Helper.prepareList('showPotenialFriends',data.data));
                        $('#action_name').text('show Potenial Friends');

                    }else{

                    }
                }
            });
        })
        $('#show_upcoming_brithdays').on('click',function () {
            let csrf_token=$('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: 'showUpcomingBrithdays',
                data: {"_token": csrf_token},
                method: 'POST',
                dataType: 'JSON',
                success: function (data) {
                    if(data['status']=='success'){
                        $('#action_data').html(Helper.prepareList('showUpcomingBrithdays',data.data));
                        $('#action_name').text('show Upcoming Brithdays');

                    }else{

                    }
                }
            });
        })

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