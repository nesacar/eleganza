@if(count($count)>0)
    @for($i=1;$i<=$count;$i++)
    <div class="form-group">
        <label for="posts" class="col-sm-2 control-label">Članak {{ $i }}</label>
        <div class="col-sm-10">
            {!! Form::select('posts[]', $posts, null, array('class' => 'form-control tag')) !!}
        </div>
    </div>
    @endfor
    {!! HTML::script('admin/plugins/select2/js/select2.min.js') !!}
    <script>
        $(".tag").select2({
            'placeholder': 'Izaberi tag',
            'tags': 'true'
        });
    </script>
@endif