@can('read_tecnico')      
	@extends('layouts.app')
	@section('title', 'Visualizar Livro')
	@section('content')
			  <h1>
		        Livro 
		        <small>{{$livro->protocolo}}</small>
		    </h1>

		    <div class="box-body col-md-6">              
              <div class="callout callout-info">
                <h5>Responsável: {{$livro->users->cargo}} <b>{{$livro->users->name}}</b></h5>
                <h5>Número de Protocolo: <b>{{$livro->protocolo}}</b></h5>                
                <h5>Início do Serviço: <b>{{date('d/m/Y H:i:s', strtotime($livro->inicio))}}</b></h5>
                <h5>Fim do Serviço: <b>{{date('d/m/Y H:i:s', strtotime($livro->fim))}}</b></h5>
                <h5>Autenticação: <b>{{$livro->autenticacao}}</b></h5>
              </div>
        </div>	

			 	
		 	
			
    <!-- Main content -->
    <section class="content">

      @if (($livro->status)==0)

      <div class="box-body col-md-12">              
              <div class="callout callout-danger">
                <h5>Este livro não foi aprovado pelo técnico de serviço: {{$livro->users->cargo}} <b>{{$livro->users->name}}.</h5>
              </div>
      </div>  

      @else

      <div class="box-body col-md-12">              
              <div class="callout callout-success">
                <h5>Este livro foi aprovado pelo técnico de serviço: {{$livro->users->cargo}} <b>{{$livro->users->name}}</b> através de senha pessoal.</h5>
              </div>
      </div> 
        
      @endif  


      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <a href="javascript:cont();" class="btn btn-info" onclick="cont();" value="">
            <i class="fa fa-print"></i>
            Imprimir
          </a>
          <br><br>
          <script type="text/javascript">
          function cont(){
             var conteudo = document.getElementById('livro').innerHTML;
             tela_impressao = window.open('about:blank');
             tela_impressao.document.write(conteudo);
             tela_impressao.window.print();
             tela_impressao.window.close();
          }
          </script>
            <div id="livro">
                <style type="text/css">
                  /* Livro para Impressão */
                  
                  .livro_brasao{
                      width: 100px;
                      text-align: center;
                      margin:auto;
                      position: relative;

                  }
                  .livro_brasao_td{
                    text-align: center;
                  }

                  .justify-tb td{
                    text-align: justify;
                  }

                  li{
                    margin-left: 15px;
                    font-weight: none!important;
                  }

                  p{
                    font-weight: none!important;
                  }

                  td, tr{
                    /*border: 1px #000000 solid;*/                   
                    
                  }

                  #acompanhar{
                    margin-left: 40px;
                  }

                </style>
                <table>
                  <tr>
                    <td align="center" width="1024px">
                      <img src="{{ asset('img/brasao-republica.png') }}" class="livro_brasao">
                    </td>
                  </tr>
                  <tr>
                    <td align="center">
                      <h5><b>Ministério da Defesa</b><br>                     
                      Comando da Aeronáutica<br>
                      Segundo Centro Integrado de Defesa Aérea e Controle de Tráfego Aéreo<br>                     
                      Divisão Técnica<br>
                      Subdivisão de Tecnologia da Informação<br>
                      Seção de Informática Operacional</h5>
                    </td>
                  </tr>
                  <tr>
                    <td align="right"><p>Livro nº <b>{{$livro->protocolo}}</b></p></td>
                  </tr>
                  <tr>
                    <td></td>
                  </tr>                 
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left"><p>&nbsp; &nbsp; &nbsp; &nbsp; Parte relativa ao serviço de técnico à {{strtoupper(str_replace('_',' ', $setor))}} do dia {{date('d/m/Y à\s H:i:s', strtotime($livro->inicio))}} até o dia {{date('d/m/Y à\s H:i:s', strtotime($livro->fim))}}.</p></td>
                  </tr>
                  <tr>
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; I - Técnico de Serviço:</b></p>
                      <ol type="A">
                        <li>{{$livro->users->cargo}} {{strtoupper($livro->users->name)}}</li>
                      </ol>
                    </td>
                  </tr>
                  <tr>
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; II - Técnicos Presentes:</b></p>
                      <ol type="A">
                          @forelse ($tecnicos as $tecnico)
                              <li>{{strtoupper($tecnico->cargo)}} {{strtoupper($tecnico->name)}}</li>
                          @empty
                      
                          @endforelse
                      </ol>
                    </td>
                  </tr>
                  <tr class="justify-tb">
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; III - Ocorrências:</b></p>
                      <ol type="A">
                        {!!html_entity_decode($livro->conteudo)!!}
                        
                      </ol>
                    </td>
                  </tr>

                  <tr class="justify-tb">
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; IV - Ações para o próximo serviço:</b></p>
                      <p><small id="acompanhar"> Acompanhar os seguintes tickets:</small></p>
                      <ol type="A">
                        {!!html_entity_decode($livro->acoes)!!}
                      </ol>
                    </td>
                  </tr>
                  <tr>
                    <td align="center"> <br><br> </td>
                    
                  </tr>

                  <tr>
                    <td align="center"> _____________________________________________________ </td>                    
                  </tr>
                  <tr>                 
                    <td align="center">{{$livro->users->cargo}} {{strtoupper($livro->users->name)}}</td>
                  </tr>

                </table>
                
            </div>
            <br><br>
            <a href="javascript:cont();" class="btn btn-info" onclick="cont();" value="">
            <i class="fa fa-print"></i>
            Imprimir
          </a>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      

    </section>
    <!-- /.content -->

      @if (($livro->status)==0)

      <div class="box-body col-md-12">              
              <div class="callout callout-danger">
                <h5>Este livro não foi aprovado pelo técnico de serviço: {{$livro->users->cargo}} <b>{{$livro->users->name}}.</h5>
              </div>
      </div>  

      @else

      <div class="box-body col-md-12">              
              <div class="callout callout-success">
                <h5>Este livro foi aprovado pelo técnico de serviço: {{$livro->users->cargo}} <b>{{$livro->users->name}}</b> através de senha pessoal.</h5>
              </div>
      </div> 
        
      @endif 

    @if (($livro->status)==0)
    <section class="content">
      <a href="{{URL::to('livros')}}/{{$setor}}/{{$livro->id}}/aprovar"  class="btn btn-success btn-md"><i class="fa fa-check"></i> Fechar Livro (Aprovar)</a>

      <a href="{{URL::to('livros')}}/{{$setor}}/{{$livro->id}}/excluir" class="btn btn-danger btn-md"><i class="fa fa-times-circle"></i> Exluir Livro (Descartar)</a>
    </section>
    @else
        
    @endif	
  @endsection
@endcan
