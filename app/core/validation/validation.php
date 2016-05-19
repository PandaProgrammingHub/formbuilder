<?php 
function validation_set($element,$value,$conditions){



  
  $error_message = array();
   
   if(is_array($conditions)){
        foreach ($conditions as $condition) {
          
         if($condition == 'required'){

            if(!required($value,$element)){
                            $error_message[$element][] = "Error: $element is a required field.";
            }
         }

        
         if ($condition == 'alpha'){
            if(!alpha($value,$element)){
                            $error_message[$element][] = "Error: $element must be alphabetic (contain only letters).";
            }
         }
         
         if ($condition == 'number'){
            if(!number($value,$element)){
                            $error_message[$element][] = "Error: $element must be Number (contain only number).";
            }
         }

         if ($condition == 'email'){
            if(!email($value,$element)){
                            $error_message[$element][] = "Error: $element must be alphanumeric (contain only numbers, letters, underscores, and/or hyphens).";
            }
         }

         if ($condition == 'url'){
            if(!url($value,$element)){
                            $error_message[$element][] = "Error: $element must contain a url (e.g. http://www.google.com).";
            }
         }
         if (preg_match("/matches_/", $condition)) {
             $con = explode('_', $condition);       
              
            if(!matches($value,$element,$con[2])){
                            $error_message[$element][] = "Error: $element value is must same with $con[2] value .";
                }
            
        }
         if (preg_match("/min_length_/", $condition)) {
             $con = explode('_', $condition);
            if(!min_length($value,$element,$con[2])){
                            $error_message[$element][] = "Error: $element min length ". $con[2];
                }            
        }

         if (preg_match("/max_length_/", $condition)){
             $con = explode('_', $condition);              
            if(!max_length($value,$element,$con[2])){
                            $error_message[$element][] = "Error: $element max length ". $con[2];
                }
            
        }


        /*switch ($condition) {
          case 'required':
                          if(!required($value,$element)){
                            $error_message[] = "Error: $element is a required field.";
                          }
                          break;

          case 'matches': foreach ($condition as $con) {
                               if(!matches($value,$element,$con)){
                                
                                $error_message[] = "Error: $element value is must same with $con value .";
                            }      
                          }
                          break;
          case 'alphaNumeric':
                              if(!alphaNumeric($value,$element)){
                                $error_message[] = "Error: $element must be alphanumeric (contain only numbers, letters, underscores, and/or hyphens).";
                              }
                                break;

          case 'alpha':
                          if(!alpha($value,$element)){
                              $error_message[] = "Error: $element must be alphabetic (contain only letters).";
                          }
                          break;
          case 'number':
                         if(!number($value,$element)){
                              $error_message[] = "Error: $element must be Number (contain only number).";
                             }
                          break;
          case 'email':
                          if(!email($value,$element)){
                          $error_message[] = "Error: $element must be alphanumeric (contain only numbers, letters, underscores, and/or hyphens).";
                          }
                          break;
          case 'url':
                          if(!url($value,$element)){
                            $error_message[] = "Error: $element must contain a url (e.g. http://www.google.com).";
                          }
                          break;
          case 'min_length': foreach ($condition as $con) {
                               if(!min_length($value,$element,$con)){
                                  $error_message[] = "Error: $element min length $con a url.";
                               }      
                              }
                             break;
          case 'max_length ': foreach ($condition as $con) {
                               if(!max_length ($value,$element,$con)){
                                $error_message[] = "Error: $element max length $con a url.";
                               }     
                              }
                              break;

          default:
        }*/
    }
  }

   return $error_message ;


}

function required($value,$element){

   if(!empty($value) || $value != ''){
      return TRUE; 
   }
   else{
         
         return FALSE;
   }
   
}
function matches($value,$element,$field){
      if ( ! isset($_POST[$field])){
         return FALSE;
}
   
      $field = $_POST[$field];
      if($value!== $field){
         return FALSE;
      }
      else{
         return TRUE;
      }

      
}

function alpha($value,$element){
    return ( ! preg_match("/^([a-z])+$/i", $value)) ? FALSE : TRUE;
}

function alphaNumeric($value,$element){
    return ( ! preg_match("/^([-a-z0-9_-])+$/i", $value)) ? FALSE : TRUE;
}


function number($value,$element){
    return ( ! preg_match("/^([0-9])+$/i", $value)) ? FALSE : TRUE;
}

function email($value,$element){

return ( ! preg_match("/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/i", $value)) ? FALSE : TRUE;

}

function url($value,$element){

    return ( ! preg_match("/((?:https?\:\/\/|www\.)(?:[-a-z0-9]+\.)*[-a-z0-9]+.*)/i", $value)) ? FALSE : TRUE;
     
}

function min_length($value, $element,$val){
      if (preg_match("/[^0-9]/", $val)){
         return FALSE;
      }      
     if (strlen($value) > $val) {
        return TRUE;
     }
     else{
     return  FALSE;
     }
}

function max_length($value, $element,$val){
      if (preg_match("/[^0-9]/", $val)){
         return FALSE;
      }      
     if (strlen($value) < $val) {
        return TRUE;
     }
     else{
      return  FALSE;
     }
}
?>