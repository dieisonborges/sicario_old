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

                  .justify-tb td{
                    text-align: justify;
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
                    <td align="center">
                      <h4>Ministério da Defesa</h4>                      
                      <h4>Comando da Aeronáutica</h4>
                      <h4>Segundo Centro Integrado de Defesa Aérea e Controle de Trafégo Aéreo</h4>
                    </td>
                  </tr>
                  <tr>
                    <td align="right">Livro nº <b>{{$livro->protocolo}}/{{$setor}}</b></td>
                  </tr>                 
                  <tr>
                    <td align="left">&nbsp;</td>
                  </tr>
                  <tr>
                    <td align="left"><p>&nbsp; &nbsp; &nbsp; &nbsp; Parte relativa ao serviço de técnico à {{str_replace('_',' ', $setor)}} do dia {{date('d/m/Y à\s h:i:s', strtotime($livro->inicio))}} até o dia {{date('d/m/Y à\s h:i:s', strtotime($livro->fim))}}.</p></td>
                  </tr>
                  <tr>
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; I - Técnicos presentes:</b></p>
                      <ol type="A">
                        <li>{{$livro->users->cargo}} {{strtoupper($livro->users->name)}}</li>
                      </ol>
                    </td>
                  </tr>
                  <tr class="justify-tb">
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; II - Ocorrências:</b></p>
                      <ol type="A">
                        {{$livro->conteudo}}
                        <li>Morbi ac molestie velit. Quisque ut erat gravida, sollicitudin nibh sit amet, aliquam mi. Pellentesque vel condimentum velit. Phasellus auctor urna massa, sit amet bibendum risus condimentum quis. Nullam bibendum, ex id varius scelerisque, dolor sapien ultricies lorem, non congue dui nisl vel tellus. Nulla et egestas sem, et fermentum lacus. Cras accumsan quis metus eget convallis. Integer in porttitor ex, vitae pretium mauris.
                          <ul>
                            <li>Fulano de Tal (12/03/2018 01:20): teste</li>
                          </ul>

                        </li>

                        <br>
                        <li>Etiam maximus justo a lacus mollis, vel hendrerit tellus ultrices. Integer est tellus, tincidunt et vulputate ac, elementum sed libero. Ut molestie molestie lorem eget placerat. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Donec auctor arcu libero, in iaculis massa ornare ac. Suspendisse potenti. Curabitur et sem id neque hendrerit molestie in in dolor. Nunc eget elit lorem. Quisque non tellus ipsum. Aliquam laoreet at massa at lacinia. </li>

                        <br>
                        <li>Morbi ac molestie velit. Quisque ut erat gravida, sollicitudin nibh sit amet, aliquam mi. Pellentesque vel condimentum velit. Phasellus auctor urna massa, sit amet bibendum risus condimentum quis. Nullam bibendum, ex id varius scelerisque, dolor sapien ultricies lorem, non congue dui nisl vel tellus. Nulla et egestas sem, et fermentum lacus. Cras accumsan quis metus eget convallis. Integer in porttitor ex, vitae pretium mauris.</li>
                      </ol>
                    </td>
                  </tr>

                  <tr class="justify-tb">
                    <td align="left">
                      <p><b>&nbsp; &nbsp; &nbsp; &nbsp; III - Ações para o próximo serviço:</b></p>
                      <ol type="A">
                        <li>Quisque consequat, neque quis pellentesque tincidunt, urna ex sollicitudin augue, a feugiat ipsum felis sit amet nunc. Phasellus sit amet massa mi.</li>

                        <br>
                        <li>Sed viverra dui vitae varius maximus. Maecenas sodales nibh dui, a bibendum lorem efficitur vel. Maecenas sed dapibus erat.</li>

                        <br>
                        <li>Morbi ac molestie velit. Quisque ut erat gravida, sollicitudin nibh sit amet, aliquam mi. Pellentesque vel condimentum velit. Phasellus auctor urna massa, sit amet bibendum risus condimentum quis. Nullam bibendum, ex id varius scelerisque, dolor sapien ultricies lorem, non congue dui nisl vel tellus. Nulla et egestas sem, et fermentum lacus. Cras accumsan quis metus eget convallis. Integer in porttitor ex, vitae pretium mauris.</li>
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

    @if (($livro->status)==1)
    <section class="content">
      <a href="{{URL::to('tecnicos')}}/{{$setor}}/{{$livro->id}}/acao"  class="btn btn-info btn-md"><i class="fa fa-plus-circle"></i> Nova Ação</a>

      <a href="{{URL::to('tecnicos')}}/{{$setor}}/{{$livro->id}}/encerrar" class="btn btn-danger btn-md"><i class="fa fa-times-circle"></i> Encerrar Livro</a>
    </section>
    @else
        
    @endif	
  @endsection
@endcan
