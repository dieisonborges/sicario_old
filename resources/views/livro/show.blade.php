@can('read_tecnico')      
	@extends('layouts.app')
	@section('title', 'Visualizar Livro')
	@section('content')
			  <h1>
		        Livro 
		        <small>{{$livro->protocolo}}</small>
		    </h1>

		    <div class="box-body col-md-4">              
              <div class="callout callout-info">
                <h5>Responsável: <b>{{$livro->users->name}}</b></h5>
                <h5>Número de Protocolo: <b>{{$livro->protocolo}}</b></h5>                
                <h5>Início do Serviço: <b>{{date('d/m/Y h:i:s', strtotime($livro->inicio))}}</b></h5>
                <h5>Fim do Serviço: <b>{{date('d/m/Y h:i:s', strtotime($livro->fim))}}</b></h5>
                <h5>Autenticação: <b>{{$livro->autenticacao}}</b></h5>
              </div>
        </div>	

			 	
		 	
			
    <!-- Main content -->
    <section class="content">

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

                  td, tr{
                    /*border: 1px #000000 solid;*/
                  }

                </style>
                <table>
                  <tr>
                    <td align="center" width="1024px">
                      <img src="{{ asset('img/brasao-republica.png') }}" class="livro_brasao">
                    </td>
                  </tr>
                  <tr>
                    <td align="center"><h4>Ministério da Defesa</h4></td>
                  </tr>
                  <tr>
                    <td align="center"><h4>Comando da Aeronáutica</h4></td>
                  </tr>
                  <tr>
                    <td  align="center"><h4>Segundo Centro Integrado de Defesa Aérea e Controle de Trafégo Aéreo</h4></td>
                  </tr>
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left"><p>&nbsp; &nbsp; &nbsp; &nbsp; Parte relativa ao serviço de técnico ao hardware do dia 01/01/2019 às 00:00 até o dia 02/01/2019 07:00</p></td>
                  </tr>
                  <tr>
                    <td align="left">
                      <p>&nbsp; &nbsp; &nbsp; &nbsp; I - Técnicos presentes:</p>
                      <p>{{$livro->users->name}}</p>

                    </td>
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

    @if (($livro->status)==1)
    <section class="content">
      <a href="{{URL::to('tecnicos')}}/{{$setor}}/{{$livro->id}}/acao"  class="btn btn-info btn-md"><i class="fa fa-plus-circle"></i> Nova Ação</a>

      <a href="{{URL::to('tecnicos')}}/{{$setor}}/{{$livro->id}}/encerrar" class="btn btn-danger btn-md"><i class="fa fa-times-circle"></i> Encerrar Livro</a>
    </section>
    @else
        
    @endif	
  @endsection
@endcan
