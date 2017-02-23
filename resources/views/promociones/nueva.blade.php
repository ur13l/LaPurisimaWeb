
<div id="tab-nueva" class="tab-pane fade in active">
    <h4 class="col-xs-12">Selecciona el tipo de promoción que deseas.</h4>
    <div class="clearfix"></div>
    <br>
    <div class="row">
        <ul class="nav nav-pills col-xs-12 col-xs-offset-1 col-md-offset-3 ">
            <li class="col-xs-3 col-md-2 text-center active"><a data-toggle="tab" href="#tab-usuario">Por usuario</a></li>
            <li class="col-xs-3 col-md-2 text-center"><a data-toggle="tab" href="#tab-producto">Por producto</a></li>
            <li class="col-xs-3 col-md-2 text-center"><a data-toggle="tab" href="#tab-general">General</a></li>
        </ul>
    </div>
    <div class="tab-content">
        <!--Tab de usuario -->
        <div id="tab-usuario" class="tab-pane fade in active">
            {{Form::open(array('id'=>'form-promo-usuario', 'url'=>url('/promociones/usuario')))}}
            <div class="form-group col-xs-12" id="form-group-usuario">
                {{Form::label('usuario', 'Usuario')}}
                <select id="u_select-usuario" class="select-usuario" name="select-usuario[]" style="width: 100%" multiple>
                </select>
                {{Form::hidden('user_id', '', array('id'=>'user_id'))}}
            </div>
            <div class="form-group col-xs-12 col-md-6" id="form-group-fecha">
                {{Form::label('fecha', 'Fecha de vencimiento')}}
                {{Form::text('fecha', '', array('id'=>'u_fecha', 'class' => 'form-control fecha'))}}
            </div>

            <div class="form-group col-xs-12 col-md-6" id="form-grouplimite">
                {{Form::checkbox('limiteChk', '1', false, array('class'=>'limiteChk', 'id'=>'u_limiteChk'))}}
                {{Form::label('Límite de usos')}}
                {{Form::number('limiteNum', '', array('class'=>'form-control limiteNum','id'=>'u_limiteNum', 'disabled'=>'disabled'))}}
            </div>
            <div class="form-group col-xs-12" id="form-grouplimite">
                {{Form::label('','Tipo de descuento')}}
            </div>

            <ul class="nav nav-pills nav-stacked col-xs-12 col-md-4">
                <li class="active"><a data-toggle="tab" href="#tab-promo-venta">Descuento por venta</a></li>
                <li><a data-toggle="tab" href="#tab-promo-producto">Descuento por producto</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active col-xs-12 col-md-8" id="tab-promo-venta">
                    <div class="panel panel-default col-xs-12">
                        <div class="panel-body text-center">
                            <h4>Descuento por venta</h4>
                            <div class="form-group col-xs-12" id="form-group-descuento">
                                {{Form::radio('descuentoRadio', 'descuentoPrecio', true)}}
                                {{Form::label('descuentoPrecio', 'Descuento en precio  &nbsp;&nbsp;')}}
                                {{Form::radio('descuentoRadio', 'descuentoPorcentaje')}}
                                {{Form::label('descuentoPorcentaje', 'Descuento por porcentaje')}}
                            </div>
                            <div class="form-group col-xs-12 col-md-8 col-md-offset-2 form-group-descuento-precio" id="form-group-descuento-precio">
                               <div class="input-group">

                                   <span class="input-group-addon">$</span>
                                    {{Form::number('descuentoPrecioInput', 0, array('class'=>'form-control', 'id'=>'u_descuentoPrecioInput', 'min'=>'0', 'max'=>'1000000'))}}
                                </div>
                            </div>
                            <div class="form-group col-xs-12 col-md-8 hide form-group-descuento-porcentaje" id="form-group-descuento-porcentaje">
                                <div class="input-group">

                                    {{Form::number('descuentoPorcInput', 0, array('class'=>'form-control', 'id'=>'u_descuentoPorcInput','min'=>'0', 'max'=>'100'))}}
                                    <span class="input-group-addon">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade in col-xs-12 col-md-8" id="tab-promo-producto">
                    <div class="panel panel-default col-xs-12">
                        <div class="panel-body">
                            <h4>Descuento por producto</h4>
                            <div class="productos-container">
                                <div class="producto-item">
                                    <div class="form-group col-xs-12" id="form-group-producto">
                                        {{Form::label('producto', 'Producto')}}
                                        <select class="select-producto" name="select-producto[]" id="u_select-producto" style="width: 100%" multiple>
                                        </select>
                                        {{Form::hidden('producto_id', '', array('id'=>'producto_id'))}}
                                    </div>
                                    <div class="col-xs-12 producto-hidden">
                                        <div class="form-group col-xs-12" id="form-group-descuento">
                                            {{Form::radio('descuentoRadio1', 'descuentoPrecio1', true)}}
                                            {{Form::label('descuentoPrecio1', 'Descuento en precio  &nbsp;&nbsp;')}}
                                            {{Form::radio('descuentoRadio1', 'descuentoPorcentaje1')}}
                                            {{Form::label('descuentoPorcentaje1', 'Descuento por porcentaje')}}
                                        </div>
                                        <div class="form-group col-xs-12 col-md-8 form-group-descuento-precio" id="form-group-descuento-precio">
                                            <div class="input-group">

                                                <span class="input-group-addon">$</span>
                                                {{Form::number('descuentoPrecioInput1', 0, array('class'=>'form-control', 'id'=>'u_descuentoPrecioInput1', 'min'=>'0', 'max'=>'1000000'))}}
                                            </div>
                                        </div>
                                        <div class="form-group col-xs-12 col-md-8 hide form-group-descuento-porcentaje" id="form-group-descuento-porcentaje">
                                            <div class="input-group">

                                                {{Form::number('descuentoPorcInput1', 0, array('class'=>'form-control', 'id'=>'u_descuentoPorcInput1', 'min'=>'0', 'max'=>'100'))}}
                                                <span class="input-group-addon">%</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <div class="text-right col-xs-12">

                    <input type="reset" class="btn btn-danger" value="Limpiar">
                    <input type="submit" class="btn btn-primary" value="Guardar">
                </div>
            </div>

            {{Form::close()}}
        </div>

        <!--Tab de producto -->
        <div id="tab-producto" class="tab-pane fade in">
            {{Form::open(array('id'=>'form-promo-producto', 'url'=>url('/promociones/producto')))}}
            <div class="form-group col-xs-12" id="form-group-producto">
                {{Form::label('producto', 'Producto')}}
                <select id="p_select-producto" class="select-producto" name="select-producto[]" style="width: 100%" multiple>
                </select>
                {{Form::hidden('producto_id', '', array('id'=>'producto_id'))}}
            </div>
            <div class="form-group col-xs-12 col-md-6" id="form-group-fecha">
                {{Form::label('fecha', 'Fecha de vencimiento')}}
                {{Form::text('fecha', '', array('id'=>'p_fecha', 'class' => 'form-control fecha'))}}
            </div>

            <div class="form-group col-xs-12 col-md-6" id="form-grouplimite">
                {{Form::checkbox('limiteChk', '1', false, array('class'=>'limiteChk', 'id'=>'p_limiteChk'))}}
                {{Form::label('Límite de usos')}}
                {{Form::number('limiteNum', '', array('class'=>'form-control limiteNum', 'disabled'=>'disabled', 'id'=>'p_limiteNum'))}}
            </div>
            <div class="form-group col-xs-12" id="form-group-descuento">
                {{Form::radio('descuentoRadio', 'descuentoPrecio', true)}}
                {{Form::label('descuentoPrecio', 'Descuento en precio  &nbsp;&nbsp;')}}
                {{Form::radio('descuentoRadio', 'descuentoPorcentaje')}}
                {{Form::label('descuentoPorcentaje', 'Descuento por porcentaje')}}
            </div>
            <div class="form-group col-xs-12 col-md-6 form-group-descuento-precio" >
                <div class="input-group">

                    <span class="input-group-addon">$</span>
                    {{Form::number('descuentoPrecioInput', 0, array('class'=>'form-control', 'id'=>'p_descuentoPrecioInput', 'min'=>'0', 'max'=>'1000000'))}}
                </div>
            </div>
            <div class="form-group col-xs-12 col-md-6 hide form-group-descuento-porcentaje">
                <div class="input-group">

                    {{Form::number('descuentoPorcInput', 0, array('class'=>'form-control', 'id'=>'p_descuentoPorcInput', 'min'=>'0', 'max'=>'100'))}}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
            <div class="text-right col-xs-12">

                <input type="reset" class="btn btn-danger" value="Limpiar">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
            {{Form::close()}}
        </div>

        <!--Tab general -->
        <div id="tab-general" class="tab-pane fade in">
            {{Form::open(array('id'=>'form-promo-general', 'url'=>url('promociones/general')))}}

            <div class="form-group col-xs-12 col-md-6" id="form-group-fecha">
                {{Form::label('fecha', 'Fecha de vencimiento')}}
                {{Form::text('fecha', '', array('id'=>'g_fecha', 'class' => 'form-control fecha'))}}
            </div>

            <div class="form-group col-xs-12 col-md-6" id="form-grouplimite">
                {{Form::checkbox('limiteChk', '1', false, array('id' => 'g_limiteChk', 'class'=>'limiteChk'))}}
                {{Form::label('Límite de usos')}}
                {{Form::number('limiteNum', '', array('class'=>'form-control limiteNum', 'disabled'=>'disabled', 'id'=>'g_limiteNum'))}}
            </div>
            <div class="form-group col-xs-12" id="form-group-descuento">
                {{Form::radio('descuentoRadio', 'descuentoPrecio', true)}}
                {{Form::label('descuentoPrecio', 'Descuento en precio  &nbsp;&nbsp;')}}
                {{Form::radio('descuentoRadio', 'descuentoPorcentaje')}}
                {{Form::label('descuentoPorcentaje', 'Descuento por porcentaje')}}
            </div>
            <div class="form-group col-xs-12 col-md-6" id="form-group-descuento-precio">
                <div class="input-group">

                    <span class="input-group-addon">$</span>
                    {{Form::number('descuentoPrecioInput', 0, array('class'=>'form-control', 'id'=>'g_descuentoPrecioInput', 'min'=>'0', 'max'=>'1000000'))}}
                </div>
            </div>
            <div class="form-group col-xs-12 col-md-6 hide" id="form-group-descuento-porcentaje">
                <div class="input-group">

                    {{Form::number('descuentoPorcInput1', 0, array('class'=>'form-control', 'id'=>'g_descuentoPorcInput', 'min'=>'0', 'max'=>'100'))}}
                    <span class="input-group-addon">%</span>
                </div>
            </div>
            <div class="text-right col-xs-12">

                <input type="reset" class="btn btn-danger" value="Limpiar">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div>
            {{Form::close()}}
        </div>

    </div>

</div>
