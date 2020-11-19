<?php
/**
 * Registries - Template
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build application
 $app=new strApplication();
 // build nav object
 $nav=new strNav("nav-tabs");
 // dashboard
 $nav->addItem(api_icon("fa-th-large",null,"hidden-link"),api_url(["scr"=>"dashboard"]));
 $nav->addItem(api_text("nav-registries-list"),api_url(["scr"=>"registries_list"]));
 // operations
 if($registry_obj->id && in_array(SCRIPT,array("registries_view","registries_edit"))){
  $nav->addItem(api_text("nav-operations"),null,null,"active");
  $nav->addSubItem(api_text("nav-registries-operations-edit"),api_url(["scr"=>"registries_edit","idRegistry"=>$registry_obj->id]),(api_checkAuthorization("registries-manage")));
  /*
  $nav->addSubSeparator();
  $nav->addSubItem(api_text("nav-registries-operations-document_add"),api_url(["scr"=>"registries_view","tab"=>"documents","act"=>"document_add","idRegistry"=>$registry_obj->id]),(api_checkAuthorization("registries-manage")));
   */
 }else{
  $nav->addItem(api_text("nav-registries-add"),api_url(["scr"=>"registries_edit"]),(api_checkAuthorization("registries-manage")));
 }
 // settings
 $nav->addItem(api_text("nav-settings"));
 $nav->addSubItem(api_text("nav-settings-roles"),api_url(["scr"=>"roles_list"]));
 // add nav to html
 $app->addContent($nav->render(false));
?>