<?php
/**
 * Registries - Registries Edit
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("registries-manage","dashboard");
 // get objects
 $registry_obj=new cRegistriesRegistry($_REQUEST['idRegistry']);
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(($registry_obj->id?api_text("registries_edit",$registry_obj->name):api_text("registries_edit-add")));
 // get form
 $form=$registry_obj->form_edit(["return"=>api_return(["scr"=>"registries_view"])]);
 // additional controls
 if($registry_obj->id){
  $form->addControl("button",api_text("form-fc-cancel"),api_return_url(["scr"=>"registries_view","idRegistry"=>$registry_obj->id]));
  if(!$registry_obj->deleted){
   $form->addControl("button",api_text("form-fc-delete"),api_url(["scr"=>"controller","act"=>"delete","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_obj->id]),"btn-danger",api_text("cRegistriesRegistry-confirm-delete"));
  }else{
   $form->addControl("button",api_text("form-fc-undelete"),api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_obj->id,"return"=>["scr"=>"registries_view"]]),"btn-warning");
   $form->addControl("button",api_text("form-fc-remove"),api_url(["scr"=>"controller","act"=>"remove","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_obj->id]),"btn-danger",api_text("cRegistriesRegistry-confirm-remove"));
  }
 }else{$form->addControl("button",api_text("form-fc-cancel"),api_url(["scr"=>"registries_list"]));}
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($form->render(),"col-xs-12");
 // add content to registry
 $app->addContent($grid->render());
 // renderize registry
 $app->render();
 // debug
 api_dump($registry_obj,"registry");
?>