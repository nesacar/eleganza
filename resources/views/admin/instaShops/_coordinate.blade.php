@if(!empty($coordinate))
    <div style="padding: 10px 0">
        <div class="form-group">
            <label for="publish" class="col-sm-2 control-label">Proizvod</label>
            <div class="col-sm-8">
                {!! Form::select('products[]', $productIds, $coordinate->product_id, ['class' => 'form-control products']) !!}
                {!! Form::hidden('x[]', $coordinate->x) !!}
                {!! Form::hidden('y[]', $coordinate->y) !!}
            </div>
            <div class="col-md-2">
                <span class="fa fa-remove" style="padding: 11px 0; cursor: pointer;"></span>
            </div>
        </div>
        <hr>
    </div>
@else
    <div style="padding: 10px 0">
        <div class="form-group">
            <label for="publish" class="col-sm-2 control-label">Proizvod</label>
            <div class="col-sm-8">
                {!! Form::select('products[]', $productIds, null, ['class' => 'form-control products']) !!}
                {!! Form::hidden('x[]', 50) !!}
                {!! Form::hidden('y[]', 50) !!}
            </div>
            <div class="col-md-2">
                <span class="fa fa-remove" style="padding: 11px 0; cursor: pointer;"></span>
            </div>
        </div>
        <hr>
    </div>
@endif