$( document ).ready(function() {
    $("#data_table .add").on("click", function(e){
        var _this = $(this);
        var wallet_id = $(this).data('wallet');
        $.ajax({
            url: '/wallets/'+wallet_id+'/amount',
            method: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: wallet_id
            },
            success: function (data) {
                if (data['success']) {
                    _this.parents('.odd').find('.amount').text(data['success']);
                    $('.add').remove();
                }
                if(data['total_sum']) {
                    $("#total_sum").text(data['total_sum']);
                }
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
        return false;
    });
    
    
    $("#from, #to").on("change",function()
    {
        let this_attr_id = $(this).attr('id');
        let this_id = $(this).val();
        if( this_attr_id == "from" ) {
            if(this_id == 1) {
                $("#from_type").html("<option value='0'>Choose Type</option>");    
            } else {
                $("#from_type").html("");  
            }
        } else {
            if(this_id == 1) {
                $("#to_type").html("<option value='0'>Choose Type</option>");
            } else {
                $("#to_type").html("");  
            }
        }
        if( this_id > 0 ) {
            $.ajax({
                url: '/transfers/getExistsTypes',
                method: 'post',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    id: this_id
                },
                success: function (data) {
                    if (data['success'])
                    {
                        if( this_attr_id == "from" ) {
                            $("#from_type").append(data['success']);
                            $("#from_type").css({"display":"block"});
                            $("#toContent").css({"display":"block"});
                        } else {
                            $("#to_type").append(data['success']);
                        }
                    }
                }
            });
        }
        return false;
    });
    
    $("#from_type, #to_type").on("change",function()
    {
        let this_attr_id = $(this).attr('id');
        let this_id = $(this).val();
        if(this_id > 0 ) {
            $("#amount").css({"display":"block"});
        } else {
            $("#amount").css({"display":"none"});
        }
    });
    
    $("#data_table_pr .add_to_card").on("click", function(e)
    {
        var _this = $(this);
        var price = $(this).data('price');
        var pr_id = $(this).data('pr');
        $.ajax({
            url: '/carts/add_to_cart',
            method: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                id: pr_id,
                pr_price: price
            },
            success: function (data) {
                if (data['view'])
                {
                    _this.parents('.odd').find('.res').html(data['view']);
                }
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
        return false;
    });
    
    $(document).on("click","#data_table_pr .pay", function(e)
    {
        var _this = $(this);
        var pay_id = $(this).data('pay_id');
        var pr_id = $(this).data('pr_id');
        
        $.ajax({
            url: '/carts',
            method: 'post',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                pay_id: pay_id,
                pr_id: pr_id
            },
            success: function (data) {
                if(data['success']) {
                    $("#status").text(data['success']);
                }
                if(data['total_sum']) {
                    $("#total_sum").text(data['total_sum']);
                }
                if(data['sel_wal']) {
                    _this.text(data['sel_wal']);
                }
                
            },
            error: function (data) {
                alert(data.responseText);
            }
        });
        
        return false;
    });
});