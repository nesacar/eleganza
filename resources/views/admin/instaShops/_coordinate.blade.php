<div style="padding: 10px 0">
    <div class="form-group">
        <label for="publish" class="col-sm-2 control-label">Pin {{ $pin }}</label>
        <div class="col-sm-8">
            {!! Form::select('products[]', $productIds, null, ['class' => 'form-control products']) !!}
            {!! Form::hidden('x[]', $x) !!}
            {!! Form::hidden('y[]', $y) !!}
        </div>
        <div class="col-md-2">
            <span class="fa fa-remove" style="padding: 11px 0; cursor: pointer;"></span>
        </div>
    </div>
    <hr>
</div>

<script>
    $('.fa-remove').click(function(){
        $(this).parent().parent().parent().remove();
    });
</script>