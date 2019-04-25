<?php
/**
 * @file
 * Contains \Drupal\d*_website_report_generator\Form\ExcelForm
 */
namespace Drupal\d8_website_report_generator\Form;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\FormBase;



class ExcelForm extends FormBase {

 public function getFormId() {
    return 'MultiSubmitForm';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

      // Show button 
      $form['submit']= array(
        '#type' => 'submit',
        '#value' => 'Generate Report',
        '#submit' => array([$this, 'submitForm']),
      );
    
    return $form;
    }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Nothing to do here.
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {

  	$types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();
    $options = [];

    // file name for download
    $fileName = "codexworld_export_data" . date('Ymd') . ".xls";

    // headers for download
    header("Content-Disposition: attachment; filename=\"$fileName\"");
    header("Content-Type: application/vnd.ms-excel");

    $flag = false;

    foreach ($types as $node_type) {
      foreach (\Drupal::entityManager()->getFieldDefinitions('node', $node_type->id() ) as $field_name   => $field_definition) {
        if (!empty($field_definition->getTargetBundle())) {

          $data =  array(array("Content Type" => $node_type->label(), "Field Name" => $field_name, "Field Type" => $field_definition->getType(), "Message" => "none"));

          foreach($data as $row) {
       
            if(!$flag) {
              // display column names as first row
        
              echo implode("\t", array_keys($row)) . "\n";
              $flag = true;
            }

            // filter data
            array_walk($row, 'filterData');
            echo implode("\t", array_values($row)) . "\n";
          }
        }
      }
    }   
    
    exit;

  }
}

