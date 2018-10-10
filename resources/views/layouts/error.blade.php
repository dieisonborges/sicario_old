                @if($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-hand-spock-o"></i> Sucesso!</h4>
                        {{$message}}
                    </div>
                @endif               

                @if($message = Session::get('status'))                 
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-hand-spock-o"></i> Sucesso!</h4>
                        {{$message}}
                    </div>
                @endif

                 @if($message = Session::get('danger'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-bane"></i> Erro!</h4>
                        {{$message}}
                    </div>
                @endif

                @if($message = Session::get('permission_error'))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Erro: {{$message}}</h4>
                        O seu usuário não tem autorização para acessar essa área.
                    </div>
                @endif

                @if(count($errors)>0)
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Erro!</h4>
                        <ul>
                            @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                