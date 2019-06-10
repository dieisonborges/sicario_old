@extends('layouts.app')
@section('title', 'Regras')
@section('content')
 

<h1>Chefes do Setor <b>{{$setor->label}}</b></h1>
<h3>Id: <b>{{$setor->id}}</b> Label: <b>{{$setor->name}}</b></h3>

<br>

<form method="POST" action="{{action('SetorController@chefeUpdate')}}">
    @csrf
    <input type="hidden" name="setor_id" value="{{$setor->id}}">
    <!--
    <select name="chefe_id">
        @forelse ($users as $user)
            <option value="{{$user->id}}">
                {{$user->cargo}} | {{$user->name}} | {{$user->email}}
            </option>
        @empty
            <option>Nenhuma Opção</option>     
        @endforelse
    </select>
    -->

    <div class="form-group col-md-6">
        <label>Adicionar Chefe:</label>
        <select name="chefe_id[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione um ou mais usuários"
                style="width: 100%;" required="required">
                @forelse ($users as $user)
                    <option value="{{$user->id}}">
                        {{$user->cargo}} | {{$user->name}} | {{$user->email}}
                    </option>
                @empty
                    <option>Nenhuma Opção</option>     
                @endforelse
                      
        </select>

    </div>
    <div class="form-group col-md-3">
        <label>Ao Setor:</label> <br>
        <span>{{$setor->name}} | <small>{{$setor->label}}</small></span>
    </div>
    <div class="form-group col-md-3" style="margin-top: 25px;">   
        <input class="btn btn-success btn-md" type="submit" value="Adicionar">
    </div>

</form>

<hr class="hr col-md-12">


<br><br><br>

    @if (session('status'))
        <div class="alert alert-success" setor="alert">
            {{ session('status') }}
        </div>
    @endif

    
    <div class="box-header ">
        <h3 class="box-title">Chefe(s):</h3>        
    </div>

    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tr>
                <th>ID</th>
                <th>Função/Posição</th>
                <th>Nome (Name)</th>
                <th>e-Mail</th>
                <th>Excluir</th>
            </tr>


            @forelse ($chefes as $chefe)
            <tr>
                <td>{{$chefe->id}}</td>
                <td>{{$chefe->cargo}}</td>
                <td>{{$chefe->name}}</td>
                <td>{{$chefe->email}}</td>
                
                <td>

                    <form method="POST" action="{{action('SetorController@chefeDestroy')}}" id="formDeleteP{{$chefe->id}}">
                        @csrf
                        <input type="hidden" name="setor_id" value="{{$setor->id}}">
                        <input type="hidden" name="chefe_id" value="{{$chefe->id}}">
                        <!--<button class="btn btn-danger btn-xs" >Excluir</button>-->
                        <!--<input type="submit" name="Excluir">-->

                        <a href="javascript:confirmDeleteP{{$chefe->id}}();" class="btn btn-danger btn-xs"> <i class="fa fa-close"></i> Excluir</a>
                    </form> 

                    <script>
                       function confirmDeleteP{{$chefe->id}}() {

                        var result = confirm('Tem certeza que deseja excluir?');

                        if (result) {
                                document.getElementById("formDeleteP{{$chefe->id}}").submit();
                          } else {
                                return false;
                            }
                        } 
                    </script>

                </td>
            </tr>                
            @empty
                
            @endforelse            
            
        </table>
    </div>
    <!-- /.box-body -->
   

@endsection
