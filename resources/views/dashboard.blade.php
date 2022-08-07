@extends('layouts.index')

@section('main')
<style>
    .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        121px;
        left:       345px;
        height:     90%;
        width:      78%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('http://i.stack.imgur.com/FhHRx.gif') 
                    50% 50% 
                    no-repeat;
    }

    body.loading .modal {
        overflow: hidden;   
    }

    body.loading .modal {
        display: block;
        padding-top: 40px;
        padding-right: 40px;
        padding-left: 0px;
    }
</style>
<div class="content-body">
    <div id="boxs">
        <div class="modal"></div>
    </div>
</div>
@endsection

@section('js')
<script>
$body = $("body");
$(document).on({
    ajaxStart: function() { $body.addClass("loading");    },
    ajaxStop: function() { $body.removeClass("loading"); }    
});
$(document).ready(function(){
    $.ajax({
        type: "GET",
        url: "dashboard/view",
        data: { },
        success: function(data){
            $('#boxs').html(data);
        }
    });
});
</script>
@endsection