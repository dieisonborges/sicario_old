@extends('layouts.app')
@section('title', 'Novo Tutorial')
@section('content')
		<h1>
	        Novo Tutorial
	        <small>Dicas, Manuais, Informações...</small>
	    </h1>
		

		<form method="POST" action="{{url('tutorials/'.$setor_atual.'/store')}}">
			@csrf			
			<div class="form-group col-lg-6">
			    <label for="titulo">Título</label>
			    <input type="text" class="form-control" id="titulo" name="titulo" value="" placeholder="Digite o título do seu tutorial..." required>
		 	</div>
		 	<div class="form-group col-md-6">
                <label>Setor</label>
                <select name="setor[]" class="form-control select2" multiple="multiple" data-placeholder="Selecione os setores que irão ter acesso ao tutorial"
                        style="width: 100%;" required="required">
	                  	@forelse ($setores as $setor)
	                        <option value="{{$setor->id}}">
	                            {{$setor->name}} | {{$setor->label}}
	                        </option>
	                    @empty
                        	<option>Nenhuma Opção</option>     
                    	@endforelse
	                  
                </select>
            </div>
		 	<div class="form-group col-lg-12">
			    <label for="palavras_chave">Palavras Chave (Separe por vírgula)</label>
			    <input type="text" class="form-control" id="palavras_chave" name="palavras_chave" value="" placeholder="Digite as palavras chave que serão usadas para buscar..." required>
		 	</div>
		 	<br>
		 	<hr class="hr">
		 	<br>
		 	<div class="form-group col-lg-12">
	            <div class="box-header">
	              <h3 class="box-title">Tutorial
	                <small>Conteúdo:</small>
	              </h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body pad">
	              
	                <textarea id="editorLoad1" name="conteudo" rows="100" cols="80"></textarea>
	              
	            </div>
          </div>
          <!-- /.box -->

		 	

		 	<div>
		 		<hr>
		 	</div>

		 	<button type="submit" class="btn btn-primary">Salvar</button>
		</form>
@endsection