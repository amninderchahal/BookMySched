<div class="w3-bar pagination w3-border w3-small w3-round w3-margin-top">
@if($data['current_page']==1)
    <a class="w3-button disabled" href="{{$uri['page_uri']}}?page=1">First</a>
    <a class="w3-button disabled" href="{{$uri['page_uri']}}?page={{$data['current_page']}}">Prev</a></li>
    @for($i=1; $i<=5; $i++)
        @if($i<= $data['last_page'])
            <a @if($i==$data['current_page'])class="w3-dark-gray w3-button" @else class="w3-button" @endif href="{{$uri['page_uri']}}?page={{$i}}">{{$i}}</a>
        @endif
    @endfor
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['current_page']+1}}">Next</a>
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['last_page']}}">Last</a>
@elseif($data['current_page']==$data['last_page'])
    <a class="w3-button" href="{{$uri['page_uri']}}?page=1">First</a>
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['current_page']-1}}">Prev</a></li>
    @for($i=$data['last_page']-5; $i<=$data['last_page']; $i++)
        @if($i>0)
            <a @if($i==$data['current_page'])class="w3-dark-gray w3-button" @else class="w3-button" @endif href="{{$uri['page_uri']}}?page={{$i}}">{{$i}}</a>
        @endif
    @endfor
    <a class="w3-button disabled" href="{{$uri['page_uri']}}?page={{$data['current_page']}}">Next</a>
    <a class="w3-button disabled" href="{{$uri['page_uri']}}?page={{$data['last_page']}}">Last</a>
@else
    <a class="w3-button" href="{{$uri['page_uri']}}?page=1">First</a>
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['current_page']-1}}">Prev</a>
    @for($i=$data['current_page']-2; $i<=$data['current_page']+2; $i++)
        @if($i>0 && $i<=$data['last_page'])
            <a @if($i==$data['current_page'])class="w3-dark-gray w3-button" @else class="w3-button" @endif href="{{$uri['page_uri']}}?page={{$i}}">{{$i}}</a>
        @endif
    @endfor
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['current_page']+1}}">Next</a>
    <a class="w3-button" href="{{$uri['page_uri']}}?page={{$data['last_page']}}">Last</a>
@endif
</div>