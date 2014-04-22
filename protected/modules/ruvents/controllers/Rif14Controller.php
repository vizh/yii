<?php

class Rif14Controller extends CController
{
  public function actionIndex()
  {
    echo json_encode([321, 454, 35287], JSON_UNESCAPED_UNICODE);
  }
} 