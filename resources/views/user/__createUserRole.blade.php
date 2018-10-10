@extends('layouts.app')
@section('title', 'User Role')
@section('content')
		<h1>
	        Novo User Role - {{$user->id}}
	        <small>Adicionar Usuário ao Grupo</small>
	    </h1>
		

		<form method="POST" action="{{url('users')}}">
			@csrf			
			<div class="form-group mb-12">
			    <label for="user_id">Usuário (ID)</label>
			    <input type="text" class="form-control" name="user_id_show" value="{{$user->id}}" disabled="disabled">
			    <input type="hidden"id="user_id" name="user_id" value="{{$user->id}}" placeholder="User ID" required>
		 	</div>
		 	<div class="form-group mb-12">
		 		<label for="role">Role (Grupo)</label>
			 	<select id="role" class="form-control" >
			 		@forelse ($roles as $role)
			 			<option value="{{$role->id}}">{{$role->name}} | <small>{{$role->label}}</small></option>
			 		@empty
			 	</select>
			 		
			</div>
            <tr>
                <td><b>Nenhuma Permissão.</b></td>
            </tr>
                
            @endforelse 
		 	


		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">Adicionar</button>
		</form>
@endsection