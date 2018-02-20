<div class="na-levo">
    @if(isset($s5))
        <ol class="breadcrumb">
            <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug.'/'.$s4->slug) }}">{{ $s4->title }}</a></li>
            <li class="active">{{ $s5->title }}</li>
        </ol>
    @elseif(isset($s4))
        <ol class="breadcrumb">
            <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug.'/'.$s3->slug) }}">{{ $s3->title }}</a></li>
            <li class="active">{{ $s4->title }}</li>
        </ol>
    @elseif(isset($s3))
        <ol class="breadcrumb">
            <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
            <li><a href="{{ url('shop/'.$s1->slug.'/'.$s2->slug) }}">{{ $s2->title }}</a></li>
            <li class="active">{{ $s3->title }}</li>
        </ol>
    @elseif(isset($s2))
        <ol class="breadcrumb">
            <li><a href="{{ url('shop/'.$s1->slug) }}">{{ $s1->title }}</a></li>
            <li class="active">{{ $s2->title }}</li>
        </ol>
    @elseif(isset($s1))
        <ol class="breadcrumb">
            <li class="active">{{ $s1->title }}</li>
        </ol>
    @endif
</div>