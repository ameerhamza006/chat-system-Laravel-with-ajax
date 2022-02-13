<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\User;
use App\Models\Chat;
use DB;
use Auth;


class ChatController extends Controller
{


public function chat(){
         
         return view('admin.pages.chats');
     }


   public function chatsend(Request $request){
        // dd($request);
         
         
         if($request->file('file')){
             $files = $request->file('file');
             $file_orignal =  $files->getClientOriginalName();
            $file_name = time(). $files->getClientOriginalExtension();
            $files->move('storage/chat/files/',$file_name);
            $image = url('/').'/'.'storage/chat/files/'.$file_name;
         
         $chat = new Chat();
         $chat->sender_id = $request->sender_id;
         $chat->message = $request->message;
         $chat->path = $image;
         $chat->file_name = $file_orignal;
         $chat->save();
         
         }else{
             
             $chat = new Chat();
         $chat->sender_id = $request->sender_id;
         $chat->message = $request->message;
         $chat->save();
             
         }
         
         $cahtsender = Chat::join('users','users.id','=','chats.sender_id')->orderBy('chats.id', 'ASC')->select('chats.*','users.role')->get();
         
         $output = '';
         
         foreach($cahtsender as $allmsg){
         if($request->type == 'user'){
                if($allmsg->sender_id != Auth::user()->id) {
            $output .= '	<h6>
								<span>
									'.$allmsg->created_at.'  -  '.$allmsg->name.' ['.$allmsg->role.']:
								</span>  ';  
								if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank" href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								   $output .= '    '.$allmsg->message.' ';
								}
							
						 $output .= '	</h6>';
                }
                
                 if($allmsg->sender_id == Auth::user()->id) {
            $output .= '	<h6>
								<span>
									'.$allmsg->created_at.'  -  You:
								</span>  ';  
								if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank"  href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								$output .= '    '.$allmsg->message.' ';
								}
							
						 $output .= '	</h6>';
                }
             
         }else{
                  if($allmsg->sender_id != Auth::user()->id) {
                  $output .= '<div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">'.$allmsg->name.' ['.$allmsg->role.']</span>
                      <span class="direct-chat-timestamp float-right">'.$allmsg->created_at.'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text" style="margin: 0px;" >';
                     
                     
                     	if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank" href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								  $output .= '    '.$allmsg->message.' ';
								}
                     
                   $output .= ' </div>
                    <!-- /.direct-chat-text -->
                  </div>';
                  }
                  
                  
                  if($allmsg->sender_id == Auth::user()->id) {
                  $output .= '<div class="direct-chat-msg right" >
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">You</span>
                      <span class="direct-chat-timestamp float-left">'.$allmsg->created_at.'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
               
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text"  style="margin: 0px;">';
                      
                     	if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank" style="color:white;" href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								   $output .= '    '.$allmsg->message.' ';
								}
                     
                   $output .= ' </div>
                    <!-- /.direct-chat-text -->
                  </div>';
                  }
         }
               
         }
         return $output;
         
        // return response()->json(['chat' => $chat, 'message' => 'success']);
         
     }

  
  
     public function chatall(){
         
         
          $cahtsender = Chat::join('users','users.id','=','chats.sender_id')->orderBy('chats.id', 'ASC')->select('chats.*','users.role')->get();
         
         $output = '';
         
         foreach($cahtsender as $allmsg){
      
      
      
                  if($allmsg->sender_id != Auth::user()->id) {
                  $output .= '<div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-left">'.$allmsg->name.' ['.$allmsg->role.']</span>
                      <span class="direct-chat-timestamp float-right">'.$allmsg->created_at.'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text" style="margin: 0px;" >';
                    if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank" href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								 $output .= '   '.$allmsg->message.' ';
								}
                  $output .= '  </div>
                    <!-- /.direct-chat-text -->
                  </div>';
                  }
                  
                  
                  if($allmsg->sender_id == Auth::user()->id) {
                  $output .= '<div class="direct-chat-msg right" >
                    <div class="direct-chat-infos clearfix">
                      <span class="direct-chat-name float-right">You</span>
                      <span class="direct-chat-timestamp float-left">'.$allmsg->created_at.'</span>
                    </div>
                    <!-- /.direct-chat-infos -->
               
                    <!-- /.direct-chat-img -->
                    <div class="direct-chat-text"  style="margin: 0px;">';
                     if($allmsg->path != ''){
							$output .= ' '.$allmsg->message.' <br>	<a target="_blank" style="color:white;" href="'.$allmsg->path.'" >'.$allmsg->file_name.'</a>';
								    
								}else{
								 $output .= '   '.$allmsg->message.' ';
								}
                  $output .= '  </div>
                    <!-- /.direct-chat-text -->
                  </div>';
                  }
                
         }
         return $output;
         
         
     }






}
