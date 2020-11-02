<?php
/**
 * Registries - Registries View
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 api_checkAuthorization("registries-usage","dashboard");
 // get objects
 $registry_obj=new cRegistriesRegistry($_REQUEST['idRegistry']);
 // check objects
 if(!$registry_obj->id){api_alerts_add(api_text("cRegistriesRegistry-alert-exists"),"danger");api_redirect("?mod=".MODULE."&scr=registries_list");}
 // deleted alert
 if($registry_obj->deleted){api_alerts_add(api_text("cRegistriesRegistry-warning-deleted"),"warning");}
 // include module template
 require_once(MODULE_PATH."template.inc.php");
 // set application title
 $app->setTitle(api_text("registries_view",$registry_obj->name));
 // check for tab
 if(!defined(TAB)){define("TAB","informations");}
 // build registries description list
 $left_dl=new strDescriptionList("br","dl-horizontal");
 $left_dl->addElement(api_text("cRegistriesRegistry-property-name"),api_tag("strong",$registry_obj->name));
 // build right description list
 $right_dl=new strDescriptionList("br","dl-horizontal");
 if($registry_obj->note){$right_dl->addElement(api_text("cRegistriesRegistry-property-note"),nl2br($registry_obj->note));}
 // include tabs
 require_once(MODULE_PATH."registries_view-informations.inc.php");
 require_once(MODULE_PATH."registries_view-documents.inc.php");
 // build view tabs
 $tab=new strTab();
 $tab->addItem(api_icon("fa-flag-o")." ".api_text("registries_view-tab-informations"),$informations_grid->render(),("informations"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-pdf-o")." ".api_text("registries_view-tab-documents"),$documents_table->render(),("documents"==TAB?"active":null));
 $tab->addItem(api_icon("fa-file-text-o")." ".api_text("registries_view-tab-logs"),api_logs_table($registry_obj->getLogs((!$_REQUEST['all_logs']?10:null)))->render(),("logs"==TAB?"active":null));
 // build grid object
 $grid=new strGrid();
 $grid->addRow();
 $grid->addCol($left_dl->render(),"col-xs-12 col-md-5");
 $grid->addCol($right_dl->render(),"col-xs-12 col-md-7");
 $grid->addRow();
 $grid->addCol($tab->render(),"col-xs-12");
 // add content to registry
 $app->addContent($grid->render());
 // renderize registry
 $app->render();
 // debug
 api_dump($registry_obj,"registry");
?>