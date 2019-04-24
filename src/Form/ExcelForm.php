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
  
    $report = \Drupal::service('d8_website_report_generator.ReportGenerator')->report_generator();

   drupal_set_message(print_r($report, true));
    
  }

}


