@extends('layouts.app')

@section('title', 'Bienvenido a App Shop')

@section('body-class', 'product-page')


@section('content')
<div class="header header-filter" style="background-image: url('https://images.unsplash.com/photo-1423655156442-ccc11daa4e99?crop=entropy&dpr=2&fit=crop&fm=jpg&h=750&ixjsv=2.1.0&ixlib=rb-0.3.5&q=50&w=1450');">
</div>

<div class="main main-raised">
    <div class="container">        

        <div class="section text-center">
            <h2 class="title">Actualizar producto</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="post" action="{{ url('/admin/products/'.$product->id.'/edit') }}">
                {{ csrf_field() }}
                
                <div class="row">
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                            <i class="material-icons">note_add</i></span>
                            <input type="text" placeholder="Nombre del producto" name="name" 
                                   class="form-control" value="{{ old('name', $product->name) }}">
                        </div>
                    </div>

                     <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                            <i class="material-icons">attach_money</i></span>
                            <input type="number" step="0.01" placeholder="Precio del producto" name="price" class="form-control" value="{{ old('price', $product->price )}}">
                        </div>                        
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-addon">
                            <i class="material-icons">add</i></span>
                            <input type="number" step="1" placeholder="Precio del producto" name="quantity" class="form-control" value="{{ old('quantity', $product->quantity )}}">
                        </div>                        
                    </div>
                </div>
                
                    <div class="row">
                      <div class="col-sm-6">
                        <div class="input-group">
                         <span class="input-group-addon">
                                <i class="material-icons">description</i></span>                       
                            <input type="text" placeholder="Descripción corta" name="description" class="form-control" value="{{ old('description', $product->description) }}">
                          </div>
                        </div>  
                        <div class="col-sm-3">
                                                       
                               <select class="form-control" name="category_id">
                                   <option value="0">Marca</option>
                                   @foreach ($categories as $category)
                                   <option value="{{ $category->id }}" @if($category->id == old('category_id', $product->category_id)) selected @endif>
                                     {{ $category->name }}
                                   </option>
                                   @endforeach
                               </select>                               
                                                 
                    </div>
                    <a href="{{ url('/admin/attributes/edit/'.$product->id.'') }} " class="btn btn-info"  >Añadir más sabores</a>
                 </div>  
                
                
                <button class="btn btn-primary">Guardar cambios</button>
                <a href="{{ url('/admin/products') }}" class="btn btn-default">Cancelar</a>

            </form>

        </div>
       
    </div>

</div>
<!-- Modal -->

@include('includes.footer')

@endsection

