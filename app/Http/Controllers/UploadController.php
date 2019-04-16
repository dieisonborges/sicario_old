<?php

namespace App\Http\Controllers;

use App\Upload;
use App\Ticket;
use Illuminate\Http\Request;
use Gate;
use DB;
use Storage;
class UploadController extends Controller
{
    /* ----------------------- LOGS ----------------------*/

    private function log($info){
        //path name
        $filename="UploadController";

        $log = new LogController;
        $log->store($filename, $info);
        return null;     
    }

    /* ----------------------- END LOGS --------------------*/

    //
    private $upload;

    public function __construct(Upload $upload){
        $this->upload = $upload;        
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $area)
    {
        //
        if(!(Gate::denies('create_upload'))){   

            //LOG ----------------------------------------------------------------------------------------
            $this->log("upload.create=".$id."area=".$area);
            //--------------------------------------------------------------------------------------------

            return view('upload.create', compact('id', 'area'));
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(!(Gate::denies('create_upload'))){

            //Validação
            $this->validate($request,[
                    'id' => 'required',
                    'area' => 'required',
                    'titulo' => 'required',
                    'file' => 'required|mimes:jpeg,png,jpg,pdf',
            ]);

            $dir = $request->input('area').'/'.$request->input('id');

            $id = $request->input('id');

            $area = $request->input('area');

            /* -------------------------------- UPLOAD --------------------*/

            $file = $request->file('file');

            // Se informou o arquivo, retorna um boolean
            //$file = $request->hasFile('file');
             
            // Se é válido, retorna um boolean
            //$file = $request->file('file')->isValid();

            // Retorna mime type do arquivo (Exemplo image/png)
            $tipo = $request->file('file')->getMimeType();
             
            // Retorna o nome original do arquivo
            $nome = $request->file('file')->getClientOriginalName();
             
            // Extensão do arquivo
            //$request->file('file')->getClientOriginalExtension();
            $ext = $request->file('file')->extension();
             
            // Tamanho do arquivo
            $tam = $request->file('file')->getClientSize();

            // Define um aleatório para o arquivo baseado no timestamps atual
            $link = uniqid(date('HisYmd'));

            // Define finalmente o nome
            $link = "{$link}.{$ext}";

            // Faz o upload:
            $upload = $request->file->storeAs($dir, $link);
            // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao


            /* -------------------------------- END UPLOAD --------------------*/

                    
            $upload = new Upload();
            $upload->titulo = $request->input('titulo');
            $upload->dir = $dir;
            $upload->link = $link;
            $upload->tipo = $tipo;
            $upload->nome = $nome;
            $upload->ext = $ext;
            $upload->tam = $tam;

            
            //LOG ----------------------------------------------------------------------------------------
            $this->log("upload.store=".$request);
            //--------------------------------------------------------------------------------------------

            if($upload->save()){

                /* ------------Vinculo do Arquivo------------- */

                $upload_id = DB::getPdo()->lastInsertId();

                //ticket
                if($area=='ticket'){
                    $status = Ticket::find($id)->uploads()->attach($upload_id);
                }                

                /* ------------END Vinculo do Arquivo------------- */

                return redirect()->back()->with('success','Upload realizado com sucesso!');
            }else{
                return redirect('uploads/'.$id.'/create/'.$area)->with('danger', 'Houve um problema, tente novamente.');
            }
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    public function fileStorageServe($file) {

        if(!(Gate::denies('read_upload'))){
                // know you can have a mapping so you dont keep the sme names as in local (you can not precsise the same structor as the storage, you can do anything)

                // any permission handling or anything else

                // we check for the existing of the file 
                if (!Storage::disk('local')->exists($file)){ // note that disk()->exists() expect a relative path, from your disk root path. so in our example we pass directly the path (/.../laravelProject/storage/app) is the default one (referenced with the helper storage_path('app')
                    abort('404'); // we redirect to 404 page if it doesn't exist
                } 
                //file exist let serve it 

                // if there is parameters [you can change the files, depending on them. ex serving different content to different regions, or to mobile and desktop ...etc] // repetitive things can be handled through helpers [make helpers]

                

                //return response()->file(storage_path('ticket'.DIRECTORY_SEPARATOR.($file)));
                return response()->file(storage_path($file)); // the response()->file() will add the necessary headers in our place (no headers are needed to be provided for images (it's done automatically) expected hearder is of form => ['Content-Type' => 'image/png'];

                // big note here don't use Storage::url() // it's not working correctly.  
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }

    

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Upload  $upload
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        //
        if(!(Gate::denies('delete_upload'))){
            $upload = Upload::find($id);  

            $file = $upload->dir.'/'.$upload->link;    

            //Apagar arquivo físico

            if(Storage::delete($file)){

                if($upload->delete()){
                    $status = true;
                }else{
                    $status = false;
                }

            }else{
               $status = false; 
            } 


            //LOG ----------------------------------------------------------------------------------------
            $this->log("upload.destroy.id=".$upload);
            //--------------------------------------------------------------------------------------------

            return redirect()->back()->with('success','Arquivo excluído com sucesso!');
        }
        else{
            return redirect('erro')->with('permission_error', '403');
        }
    }
}
