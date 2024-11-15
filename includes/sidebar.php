<?php 

$aMan = array();
$aCat = array();
$aPcat = array();

// This is for manufacturers Begin //

if(isset($_REQUEST['man'])&&is_array($_REQUEST['man'])){

    foreach($_REQUEST['man'] as $sKey=>$sVal){

        if((int)$sVal!=0){

            $aMan[(int)$sVal] = (int)$sVal;

        }

    }

}

// This is for manufacturers Finisih //

// This is for categories Begin //

if(isset($_REQUEST['cat'])&&is_array($_REQUEST['cat'])){

    foreach($_REQUEST['cat'] as $sKey=>$sVal){

        if((int)$sVal!=0){

            $aCat[(int)$sVal] = (int)$sVal;

        }

    }

}

// This is for categories Finisih //

// This is for products_categories Begin //

if(isset($_REQUEST['p_cat'])&&is_array($_REQUEST['p_cat'])){

    foreach($_REQUEST['p_cat'] as $sKey=>$sVal){

        if((int)$sVal!=0){

            $aPcat[(int)$sVal] = (int)$sVal;

        }

    }

}

// This is for products_categories Finisih //

