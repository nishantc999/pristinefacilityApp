<?php 


 function ispermission($module,$permission){



    if(auth()->user()->role_id==0){
       return true;
    }

    else {
        $permissions=App\Models\Roles::where('id',auth()->user()->role_id)->value('permission');
       
        if (array_key_exists($module, $permissions)) {
            
            if(array_search($permission,$permissions[$module])!==false){
               
                return true;
            }else{
                return false;
            }
           
        } else {
            return false;
        }

    }
}

 function ispermissionapi($module,$permission){



    if(auth('apigaurd')->user()->role_id==0){
       return true;
    }

    else {
        $permissions=App\Models\Roles::where('id',auth('apigaurd')->user()->role_id)->value('permission');
       
        if (array_key_exists($module, $permissions)) {
            
            if(array_search($permission,$permissions[$module])!==false){
               
                return true;
            }else{
                return false;
            }
           
        } else {
            return false;
        }

    }
}
 function ispermission_404($module,$permission){



    if(auth()->user()->role_id==0){
       return true;
    }

    else {
        $permissions=App\Models\Roles::where('id',auth()->user()->role_id)->value('permission');
       
        if (array_key_exists($module, $permissions)) {
            
            if(array_search($permission,$permissions[$module])!==false){
               
                return true;
            }else{
                abort(404);  
            }
           
        } else {
            abort(404); 
        }

    }
}


?>