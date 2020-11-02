<?php
/**
 * Registries - Registries List
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
 $app->setTitle(api_text("registries_list"));
 // definitions
 $registries_array=array();
 // build filter
 $filter=new strFilter();
 $filter->addSearch(["name","vat","fiscal","url","iban","note"]);
 // build query object
 $query=new cQuery("registries__registries",$filter->getQueryWhere());
 $query->addQueryOrderField("name");
 // build pagination object
 $pagination=new strPagination($query->getRecordsCount());
 // cycle all results
 foreach($query->getRecords($pagination->getQueryLimits()) as $result_f){$registries_array[$result_f->id]=new cRegistriesRegistry($result_f);}
 // build table
 $table=new strTable(api_text("registries_list-tr-unvalued"));
 $table->addHeader($filter->link(api_icon("fa-filter",api_text("filters-modal-link"),"hidden-link")),"text-center",16);
 $table->addHeader(api_text("cRegistriesRegistry-property-name"),null,"100%");
 $table->addHeader("&nbsp;",null,16);
 $table->addHeader(api_text("cRegistriesRegistry-property-roles"),"nowrap text-right");
 // cycle all registries
 foreach($registries_array as $registry_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["scr"=>"registries_edit","idRegistry"=>$registry_fobj->id,"return"=>["scr"=>"registries_list"]]),"fa-pencil",api_text("table-td-edit"),(api_checkAuthorization("registries-manage")));
  if($registry_fobj->deleted){$ob->addElement(api_url(["scr"=>"controller","act"=>"undelete","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_fobj->id,"return"=>["scr"=>"registries_list"]]),"fa-trash-o",api_text("table-td-undelete"),(api_checkAuthorization("registries-manage")),api_text("cRegistriesRegistry-confirm-undelete"));}
  else{$ob->addElement(api_url(["scr"=>"controller","act"=>"delete","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_fobj->id,"return"=>["scr"=>"registries_list"]]),"fa-trash",api_text("table-td-delete"),(api_checkAuthorization("registries-manage")),api_text("cRegistriesRegistry-confirm-delete"));}
  // make table row class
  $tr_class_array=array();
  if($registry_fobj->id==$_REQUEST['idRegistry']){$tr_class_array[]="currentrow";}
  if($registry_fobj->deleted){$tr_class_array[]="deleted";}
  // make roles
  $roles_array=array();
  foreach($registry_fobj->getRoles() as $role_fobj){$roles_array[]=$role_fobj->getLabel(false,true,"right");}
  // build registries row
  $table->addRow(implode(" ",$tr_class_array));
  $table->addRowFieldAction(api_url(["scr"=>"registries_view","idRegistry"=>$registry_fobj->id]),"fa-search",api_text("table-td-view"));
  $table->addRowField($registry_fobj->name,"truncate-ellipsis");
  $table->addRowField($registry_fobj->getTypologyLabel(false,true),"nowrap");
  $table->addRowField(implode("&nbsp;&nbsp;&nbsp;",$roles_array),"nowrap text-right");
 }
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($filter->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($table->render(),"col-xs-12");
 $grid->addRow();
 $grid->addCol($pagination->render(),"col-xs-12");
 // add content to registry
 $app->addContent($grid->render());
 // renderize registry
 $app->render();
 // debug
 api_dump($query,"query");
?>