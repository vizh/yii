<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 29.04.14
 * Time: 16:33
 */

class TestController extends \application\components\controllers\BaseController
{
  public function actionIndex()
  {
    echo "
    <html>
        <head>
            <script>
              function ridloadresrc(d,s,id,p){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=\"http://runet-id.com/\"+p;fjs.parentNode.insertBefore(js,fjs);}}ridloadresrc(document,\"script\",\"ridwjs\",\"javascripts/api/widgets.js\");ridloadresrc(document,\"script\",\"easyXDM-2.4.19.3\",\"javascripts/easyXDM.min.js\");
            </script>
        </head>
        <body>
          <div class=\"rid-widget\" data-widget=\"pay\" data-apikey=\"t826ybtyi6\"></div>
        </body>
      </html>
    ";
  }
}