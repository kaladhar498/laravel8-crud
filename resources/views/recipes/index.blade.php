@extends('layouts.app')
@section('title', 'Recipe  List')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>MyApp - RecipesList </h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('recipes.create') }}" title="Create a product">
                 <i class="fas fa-plus-circle"></i>
                  Create Recipe
                    </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{$message}}</p>
        </div>
    @endif

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Ingredients</th>
            <th>Description</th>
            <th>IsFavourite</th>
            <th>Make Fav</th>
            <th>Actions</th>
        </tr>
        @php $i=0; @endphp
        @foreach ($recipes as $recipe)
        
            <tr>
                <td>{{ ++$i }}</td>
                <td>{{ $recipe['name'] }}</td>
                <td>{{ $recipe['ingredients'] }}</td>
                <td>{{ $recipe['description'] }}</td>
                <td>{{ $recipe['isFavourite'] == 0 ? 'UnFavourite' : 'Favourite' }}</td>
                <td>
                    {!! Form::model($recipe, ['method' => 'PATCH', 
                      'route' => ['recipes.bookmark', $recipe['id']]]) !!}                                 
                      <button type="submit" title="bookmark" style="border: none; background-color:transparent;">
                            <i class="fas fa-bookmark text-success  fa-lg"></i>
                        </button>                                
                    {!! Form::close() !!} 
                </td>
                <td>
                    <form action="{{ route('recipes.destroy',$recipe['id']) }}"
                     method="POST">

                        <a href="{{ route('recipes.edit',$recipe['id']) }}">
                            <i class="fas fa-edit  fa-lg"></i>
                        </a>

                        @csrf
                        @method('DELETE')

                        <button type="submit" title="delete" style="border: none; background-color:transparent;">
                            <i class="fas fa-trash fa-lg text-danger"></i>
                        </button>
                      
                    </form>                    
                </td>
            </tr>
             @endforeach
    </table>

@endsection
