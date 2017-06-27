@extends('layout')

@section('content')
    
    <div class="text-center row">
        <img src="/images/cards.jpg" alt="" title=""/>
    </div><hr>

    @if(!empty($data))
        <div id="box_cards" class="row">
            @foreach ($data as $category => $cards)
            <div class="col-md-3">
                <h3><span class="label label-default">{{$category}}</span></h3>
                <hr>
                @foreach ($cards as $card)
                    <span>{{$card->getValue()}}</span><hr>
                @endforeach

            </div>
            @endforeach
        </div>
        <a href="#" class="btn btn-primary" id="check_result">Vérifer ce résultat</a>
        <hr>
        <div id="message" class="text-center alert" role="alert"></div>
    @else
        <div class="text-center alert alert-warning" role="alert">
            <strong>Les données sont indisponibles pour le moments, actualiez cette page !</strong>
        </div>
    @endif;
@stop

@section('scripts')
<script type="text/javascript">
    //Init params js
    var json_to_send = '<?php echo $json; ?>';
    var exerciceId = '<?php echo $exerciceId; ?>';

    $('#check_result').click(function(){
        $message = $("#message");
        $message.text("");
        $.ajax({
            'url'        : '/api/cards/check',
            'method'       : "POST",
            'dataType'   : 'json',
            'data'       : {'json_to_send' : json_to_send, 'exerciceId' : exerciceId},
            success: function(result){
                if(result == "200"){
                    message = "Cartes tirées avec succés";
                    classe = "alert-success";
                }else{
                    message = "Cartes non tirées !";
                    classe = "alert-danger";
                }
                $message.addClass(classe);
                $message.text(message);
            }
        });      
        return false;
    }); 
</script>
@stop