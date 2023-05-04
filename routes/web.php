<?php

use App\Models\Content;
use App\Models\KeyWord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
 

Route::get('/', function () {
    $keywords =  KeyWord::get();   
    return view('keyword',compact('keywords'));
});

Route::post('save', function (Request $request) { 

    $KeyWord = new KeyWord;
    $KeyWord->keywords = $request->keywords;
    $KeyWord->title = $request->title;
    $KeyWord->save();

    $keyword_data =  KeyWord::find($KeyWord->id);    
    $keyword = explode(",", $keyword_data->keywords);
    $count = count($keyword); 
    for($i=0; $i<$count; $i++){  
        $body = json_encode(['model' => 'gpt-3.5-turbo','messages' =>[['role' => 'user','content' => $keyword[$i]]]]);  
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json', 
            ])->withToken('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')->withBody($body, 'application/json')->post('https://api.openai.com/v1/chat/completions'); 
            $json_response_content =  json_decode((string) $response->getBody(), true);     
            if($response->failed()){
                dd($json_response_content['error']['message']);
            }  
        }catch(Exception $error){
            dd('Content API Error'.$error);
        } 

        $body_image = json_encode(
            [
                'model' => 'image-alpha-001',
                'prompt' =>  $keyword[$i],
                'num_images' => 1,
                'size' => '512x512',
                'response_format'=>'url' 
            ]); 

        try{
            $response_image = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json', 
            ])->withToken('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')->withBody($body_image, 'application/json')->post('https://api.openai.com/v1/images/generations');  
        }catch(Exception $error_image){
            dd('Image API ERROR'.$error_image);
        }  
        $json_response_image =  json_decode((string) $response_image->getBody(), true);  
        if($response_image->failed()){
            dd($json_response_image['error']['message']);
        } 
        $content = new Content;
        $content->parent = $keyword_data->id;
        $content->keyword = $keyword[$i];
        $content->content = $json_response_content['choices'][0]['message']['content'];
        $content->image = $json_response_image['data'][0]['url'];
        $content->save();

    } 
    return back()->with('success','Content Generated');
})->name('save');


Route::get('generate-content/{id}', function ($id) { 
    dd(111);
    $keyword_data =  KeyWord::find($id);    
    $keyword = explode(",", $keyword_data->keywords);
    $count = count($keyword); 
    for($i=0; $i<$count; $i++){  
        $body = json_encode(['model' => 'gpt-3.5-turbo','messages' =>[['role' => 'user','content' => $keyword[$i]]]]);  
        try{
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json', 
            ])->withToken('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')->withBody($body, 'application/json')->post('https://api.openai.com/v1/chat/completions'); 
            $json_response_content =  json_decode((string) $response->getBody(), true);     
            if($response->failed()){
                dd($json_response_content['error']['message']);
            }

           
        }catch(Exception $error){
            dd('Content API Error'.$error);
        } 

        $body_image = json_encode(
            [
                'model' => 'image-alpha-001',
                'prompt' =>  $keyword[$i],
                'num_images' => 1,
                'size' => '512x512',
                'response_format'=>'url' 
            ]); 

        try{
            $response_image = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json', 
            ])->withToken('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')->withBody($body_image, 'application/json')->post('https://api.openai.com/v1/images/generations');  
        }catch(Exception $error_image){
            dd('Image API ERROR'.$error_image);
        }  
        $json_response_image =  json_decode((string) $response_image->getBody(), true);  
        if($response_image->failed()){
            dd($json_response_image['error']['message']);
        }
       
       
       
        $content = new Content;
        $content->parent = $keyword_data->id;
        $content->keyword = $keyword[$i];
        $content->content = $json_response_content['choices'][0]['message']['content'];
        $content->image = $json_response_image['data'][0]['url'];
        $content->save();

    }
    return back()->with('success','You Content & Image Has Been Generated ')->with('id',$keyword_data->id);
})->name('generate-content');


Route::get('/view-content/{id}', function ($id) {
    
    $data = Content::where('parent',$id)->get();
    return view('view_content',compact('data'));
})->name('view-content');;
