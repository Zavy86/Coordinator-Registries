<?php
/**
 * Registries - Controller
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */

 // debug
 api_dump($_REQUEST,"_REQUEST");
 // check if object controller function exists
 if(function_exists($_REQUEST['obj']."_controller")){
  // call object controller function
  call_user_func($_REQUEST['obj']."_controller",$_REQUEST['act']);
 }else{
  api_alerts_add(api_text("alert_controllerObjectNotFound",[MODULE,$_REQUEST['obj']."_controller"]),"danger");
  api_redirect("?mod=".MODULE);
 }

 /**
  * Role controller
  *
  * @param string $action Object action
  */
 function cRegistriesRole_controller($action){
  // check authorizations
  api_checkAuthorization("registry-manage","dashboard");
  // get object
  $role_obj=new cRegistriesRole($_REQUEST['idRole']);
  api_dump($role_obj,"role object");
  // check object
  if($action!="store" && !$role_obj->id){api_alerts_add(api_text("cRegistriesRole-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=roles_list");}
  // execution
  try{
   switch($action){
    case "store":
     $role_obj->store($_REQUEST);
     api_alerts_add(api_text("cRegistriesRole-alert-stored"),"success");
     break;
    case "delete":
     $role_obj->delete();
     api_alerts_add(api_text("cRegistriesRole-alert-deleted"),"warning");
     break;
    case "undelete":
     $role_obj->undelete();
     api_alerts_add(api_text("cRegistriesRole-alert-undeleted"),"warning");
     break;
    case "remove":
     $role_obj->remove();
     api_alerts_add(api_text("cRegistriesRole-alert-removed"),"warning");
     break;
    default:
     throw new Exception("Role action \"".$action."\" was not defined..");
   }
   // redirect
   api_redirect(api_return_url(["scr"=>"roles_list","idRole"=>$role_obj->id]));
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,api_url(["scr"=>"roles_list","idRole"=>$role_obj->id]),"cRegistriesRole-alert-error");
  }
 }

 /**
  * Registry controller
  *
  * @param string $action Object action
  */
 function cRegistriesRegistry_controller($action){
  // check authorizations
  api_checkAuthorization("registries-manage","dashboard");
  // get object
  $registry_obj=new cRegistriesRegistry($_REQUEST['idRegistry']);
  api_dump($registry_obj,"registry object");
  // check object
  if($action!="store" && !$registry_obj->id){api_alerts_add(api_text("cRegistriesRegistry-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=registries_list");}
  // execution
  try{
   switch($action){
    case "store":
     $registry_obj->store($_REQUEST);
     api_alerts_add(api_text("cRegistriesRegistry-alert-stored"),"success");
     break;
    case "delete":
     $registry_obj->delete();
     api_alerts_add(api_text("cRegistriesRegistry-alert-deleted"),"warning");
     break;
    case "undelete":
     $registry_obj->undelete();
     api_alerts_add(api_text("cRegistriesRegistry-alert-undeleted"),"warning");
     break;
    case "remove":
     $registry_obj->remove();
     api_alerts_add(api_text("cRegistriesRegistry-alert-removed"),"warning");
     break;
    default:
     throw new Exception("Registry action \"".$action."\" was not defined..");
   }
   // redirect
   api_redirect(api_return_url(["scr"=>"registries_list","idRegistry"=>$registry_obj->id]));
  }catch(Exception $e){
   // dump, alert and redirect
   api_redirect_exception($e,api_url(["scr"=>"registries_list","idRegistry"=>$registry_obj->id]),"cRegistriesRegistry-alert-error");
  }
 }

?>