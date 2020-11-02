<?php
/**
 * Registries - Registries View (Documents)
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // build documents table
 $documents_table=new strTable(api_text("registries_view-documents-tr-unvalued"));
 $documents_table->addHeader("&nbsp;",null,16);
 $documents_table->addHeader(api_text("cArchiveDocument-property-id"),"nowrap");
 $documents_table->addHeader("&nbsp;",null,16);
 $documents_table->addHeader(api_text("cArchiveDocument-property-date"),"nowrap");
 $documents_table->addHeader(api_text("cArchiveDocument-property-name"),null,"100%");
 $documents_table->addHeader("&nbsp;",null,16);
 // cycle all documents
 foreach($registry_obj->getDocuments() as $document_fobj){
  // build operation button
  $ob=new strOperationsButton();
  $ob->addElement(api_url(["mod"=>"archive","scr"=>"controller","act"=>"download","obj"=>"cArchiveDocument","idDocument"=>$document_fobj->id,"return"=>["mod"=>"registries","scr"=>"registries_view","tab"=>"documents","idRegistry"=>$registry_obj->id]]),"fa-download",api_text("table-td-download"),true,null,null,null,null,"_blank");
  $ob->addElement(api_url(["scr"=>"controller","act"=>"document_remove","obj"=>"cRegistriesRegistry","idRegistry"=>$registry_obj->id,"idDocument"=>$document_fobj->id,"return"=>["scr"=>"registries_view","tab"=>"documents"]]),"fa-trash",api_text("table-td-remove"),(api_checkAuthorization("registries-manage")),api_text("cRegistriesRegistry-confirm-document_remove"));
  // make table row class
  $tr_class_array=array();
  if($document_fobj->id==$_REQUEST['idDocument']){$tr_class_array[]="currentrow";}
  // make project row
  $documents_table->addRow(implode(" ",$tr_class_array));
  $documents_table->addRowFieldAction(api_url(["mod"=>"archive","scr"=>"documents_view","idDocument"=>$document_fobj->id]),"fa-search",api_text("table-td-view"),null,null,null,null,"_blank");
  $documents_table->addRowField(api_tag("samp",$document_fobj->id),"nowrap");
  $documents_table->addRowField($document_fobj->getCategory()->getDot(),"nowrap text-center");
  $documents_table->addRowField(api_date_format($document_fobj->date,api_text("date")),"nowrap");
  $documents_table->addRowField($document_fobj->name,"truncate-ellipsis");
  $documents_table->addRowField($ob->render(),"text-right");
 }
?>