<ol class="breadcrumb">
    @if(isset($s6))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug) }}">{{ $s4->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug.'/'.$s5->slug) }}">{{ $s5->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug.'/'.$s5->slug.'/'.$s6->slug) }}">{{ $s6->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @elseif(isset($s5))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug) }}">{{ $s4->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug.'/'.$s5->slug) }}">{{ $s5->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @elseif(isset($s4))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug) }}">{{ $s4->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @elseif(isset($s3))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @elseif(isset($s2))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @elseif(isset($s1))
        <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
        @if(false)<li class="active">{{ $product->title }}</li>@endif
    @endif
</ol>
