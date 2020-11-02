<?php
/**
 * Registries - Roles List
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("registries-usage","dashboard");
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // definitions
 $users_array=array();
 // set application title
 $app->setTitle(api_text("roles_list"));
 // build table
 $table=new strTable(api_text("roles_list-tr-unvalued"));
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("cRegistriesRole-property-name"),"nowrap");
 $table->addHeader(api_text("cRegistriesRole-property-title"),null,"100%");
 if(!api_checkAuthorization("devices-manage")){$table->addHeader("&nbsp;",null,16);}
 else{$table->addHeaderAction(api_url(["scr"=>"roles_list","act"=>"role_add"]),"fa-plus",api_text("roles_list-td-add"),null,"text-right");}
 // cycle all roles
 foreach(api_sortObjectsArray(cRegistriesRole::availables(true),"name") as $role_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["scr"=>"roles_list","act"=>"role_edit","idRole"=>$role_fobj->id]),"fa-pencil",api_text("table-td-edit"),(api_checkAuthorization("registries-manage")));
  $ob->addElement(api_url(["scr"=>"controller","act"=>"remove","obj"=>"cRegistriesRole","idRole"=>$role_fobj->id,"return"=>["scr"=>"roles_list"]]),"fa-trash",api_text("table-td-remove"),(api_checkAuthorization("registries-manage") && !count($role_fobj->getRegistries())),api_text("cRegistriesRole-confirm-remove"));
  // make table row class
  $tr_class_array=array();
  if($role_fobj->id==$_REQUEST['idRole']){$tr_class_array[]="currentrow";}
  if($role_fobj->deleted){$tr_class_array[]="deleted";}
  // make row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowField($role_fobj->getIcon(),"nowrap");
  $table->addRowField($role_fobj->name,"nowrap");
  $table->addRowField($role_fobj->title,"truncate-ellipsis");
  $table->addRowField($ob->render(),"nowrap text-right");
 }
 // check for add or edit action
 if(in_array(ACTION,["role_add","role_edit"]) && api_checkAuthorization("registries-manage")){
  // get selected role
  $selected_role_obj=new cRegistriesRole($_REQUEST['idRole']);
  // get form
  $form=$selected_role_obj->form_edit(["return"=>["scr"=>"roles_list","tab"=>"roles","idHouse"=>$house_obj->id]]);
  // additional controls
  $form->addControl("button",api_text("form-fc-cancel"),"#",null,null,null,"data-dismiss='modal'");
  if($selected_role_obj->id && !count($selected_role_obj->getRegistries())){
   $form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cRegistriesRole","idRole"=>$selected_role_obj->id]),"btn-danger",api_text("cRegistriesRole-confirm-remove"));
  }
  // form scripts
  $app->addScript("/* Font Awesome Icon Picker */\n$(function(){\$(\"#form_registries_role_edit_form_input_icon\").iconpicker();});");
  // build modal
  $modal=new strModal(api_text("roles_list-modal-title-".($selected_role_obj->id?"edit":"add")),null,"roles_list-role");
  $modal->setBody($form->render(1));
  // add modal to house
  $app->addModal($modal);
  // modal scripts
  $app->addScript("$(function(){\$('#modal_roles_list-role').modal({show:true,backdrop:'static',keyboard:false});});");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 // add content to role
 $app->addContent($grid->render());
 // renderize role
 $app->render();
 // debug
 if(is_object($selected_role_obj)){api_dump($selected_role_obj,"selected role");}
?>