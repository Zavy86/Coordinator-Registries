<?php
/**
 * Registries - Registries View (Informations)
 *
 * @package Coordinator\Modules\Registries
 * @author  Manuel Zavatta <manuel.zavatta@gmail.com>
 * @link    http://www.coordinator.it
 */
 // make roles
 $roles_array=array();
 foreach($registry_obj->getRoles() as $role_fobj){$roles_array[]=$role_fobj->getLabel(false,true,"left");}
 // build left informations description list
 $informations_left_dl=new strDescriptionList("br","dl-horizontal");
 if($registry_obj->fiscal){$informations_left_dl->addElement(api_text("cRegistriesRegistry-property-fiscal"),$registry_obj->fiscal);}
 if($registry_obj->vat){$informations_left_dl->addElement(api_text("cRegistriesRegistry-property-vat"),$registry_obj->vat);}
 if($registry_obj->url){$informations_left_dl->addElement(api_text("cRegistriesRegistry-property-url"),api_link($registry_obj->url,$registry_obj->url,null,null,false,null,null,null,"_blank"));}
 if($registry_obj->mail){$informations_left_dl->addElement(api_text("cRegistriesRegistry-property-mail"),api_link("mailto:".$registry_obj->mail,$registry_obj->mail));}
 // build right informations description list
 $informations_right_dl=new strDescriptionList("br","dl-horizontal");
 $informations_right_dl->addElement(api_text("cRegistriesRegistry-property-typology"),$registry_obj->getTypologyLabel(true,true));
 $informations_right_dl->addElement(api_text("cRegistriesRegistry-property-roles"),implode("<br>",$roles_array));
 // build informations grid
 $informations_grid=new strGrid();
 $informations_grid->addRow();
 $informations_grid->addCol($informations_left_dl->render(),"col-xs-12 col-md-6");
 $informations_grid->addCol($informations_right_dl->render(),"col-xs-12 col-md-6");
?>