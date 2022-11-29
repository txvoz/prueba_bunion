<?php

class TablePDF extends FPDF {

// Load data
  function LoadData($file) {
    // Read file lines
    $lines = file($file);
    $data = array();
    foreach ($lines as $line)
      $data[] = explode(';', trim($line));
    return $data;
  }

// Simple table
  function BasicTable($header, $data) {
    // Header
    foreach ($header as $col)
      $this->Cell(40, 7, $col, 1);
    $this->Ln();
    // Data
    foreach ($data as $row) {
      foreach ($row as $col)
        $this->Cell(40, 6, $col, 1);
      $this->Ln();
    }
  }

// Better table
  function ImprovedTable($header, $data) {
    // Column widths
    $w = array(40, 35, 40, 45);
    // Header
    for ($i = 0; $i < count($header); $i++)
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
    $this->Ln();
    // Data
    foreach ($data as $row) {
      $this->Cell($w[0], 6, $row[0], 'LR');
      $this->Cell($w[1], 6, $row[1], 'LR');
      $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R');
      $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R');
      $this->Ln();
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

// Colored table
  function FancyTable($header, $data) {
    // Colors, line width and bold font
    $this->SetFillColor(255, 0, 0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128, 0, 0);
    $this->SetLineWidth(.3);
    $this->SetFont('', 'B');
    // Header
    $w = array(40, 35, 40, 45);
    for ($i = 0; $i < count($header); $i++)
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(224, 235, 255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach ($data as $row) {
      $this->Cell($w[0], 6, $row[0], 'LR', 0, 'L', $fill);
      $this->Cell($w[1], 6, $row[1], 'LR', 0, 'L', $fill);
      $this->Cell($w[2], 6, number_format($row[2]), 'LR', 0, 'R', $fill);
      $this->Cell($w[3], 6, number_format($row[3]), 'LR', 0, 'R', $fill);
      $this->Ln();
      $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }
// Colored table
  function FancyTable2($header, $data) {
    // Colors, line width and bold font
    $this->SetFillColor(131, 188, 243);//Color de fondo Cabecera
    $this->SetTextColor(255);//Color de texto Cabecera
    $this->SetDrawColor(0, 0, 0);//Color de linea 
    $this->SetLineWidth(.3);
    $this->SetFont('', 'B');
    // Header
    $w = array(40, 40, 30, 40,20);
    for ($i = 0; $i < count($header); $i++)
      $this->Cell($w[$i], 7, $header[$i], 1, 0, 'C', true);
    $this->Ln();
    // Color and font restoration
    $this->SetFillColor(232, 252, 255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Data
    $fill = false;
    foreach ($data as $usuario) {
      $usuario instanceof Usuario;
      $this->Cell($w[0], 6, $usuario->getUsuIdentificacion(), 'LR', 0, 'L', $fill);
      $this->Cell($w[1], 6, $usuario->getUsuNombres(), 'LR', 0, 'L', $fill);
      $this->Cell($w[2], 6, $usuario->getUsuGenero(), 'LR', 0, 'L', $fill);
      $this->Cell($w[3], 6, $usuario->getUsuFechaNacimiento(), 'LR', 0, 'L', $fill);
      $this->Cell($w[4], 6, $usuario->getEdad(), 'LR', 0, 'L', $fill);
      
      $this->Ln();
      $fill = !$fill;
    }
    // Closing line
    $this->Cell(array_sum($w), 0, '', 'T');
  }

}
