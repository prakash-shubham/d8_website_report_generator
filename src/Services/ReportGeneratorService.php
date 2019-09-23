<?php

namespace Drupal\d8_website_report_generator\Services;


class ReportGeneratorService {
  
  function report_generator() {
  
    $types = \Drupal::entityTypeManager()
      ->getStorage('node_type')
      ->loadMultiple();
    $options = [];
    foreach ($types as $node_type) {
      //$options[$node_type->id()] = $node_type->label();
      $entitytype = [];
      $fieldtype = [];
      foreach (\Drupal::entityManager()->getFieldDefinitions('node', $node_type->id() ) as $field_name   => $field_definition) {
        if (!empty($field_definition->getTargetBundle())) {
          $options[$node_type->id()][$field_name]= $field_definition->getType();

        }
      }
    }
    return $options;
  }
}
