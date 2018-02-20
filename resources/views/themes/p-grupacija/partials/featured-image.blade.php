@if(isset($featured) && $featured != '')
<div class="featured">
    {!! HTML::image($featured) !!}
    <div class="caption">
        <!--Tag Heuer Carrera-->
        <a href="#"><span class="caption-arrow"></span></a>
    </div>
</div>
@endif