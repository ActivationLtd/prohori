<div class="clearfix"></div>
@foreach($messages as $message)


    <div class="col-md-12 no-padding">
        <?php
        /** @var $message \App\Message */
        ?>
        <b>{{$message->creator->email}} <i>{{$message->created_at->diffForHumans()}}</i> : </b>
        {{$message->body}}
    </div>
    <hr/>
@endforeach
