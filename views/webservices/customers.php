<html><head><title>CRUD Tutorial - Retrieve example</title></head><body>

        <?php

        use app\models\Identidad;

/*

         * 2007-2013 PrestaShop

         *

         * NOTICE OF LICENSE

         *

         * This source file is subject to the Open Software License (OSL 3.0)

         * that is bundled with this package in the file LICENSE.txt.

         * It is also available through the world-wide-web at this URL:

         * http://opensource.org/licenses/osl-3.0.php

         * If you did not receive a copy of the license and are unable to

         * obtain it through the world-wide-web, please send an email

         * to license@prestashop.com so we can send you a copy immediately.

         *

         * DISCLAIMER

         *

         * Do not edit or add to this file if you wish to upgrade PrestaShop to newer

         * versions in the future. If you wish to customize PrestaShop for your

         * needs please refer to http://www.prestashop.com for more information.

         *

         *  @author PrestaShop SA <contact@prestashop.com>

         *  @copyright  2007-2013 PrestaShop SA

         *  @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)

         *  International Registered Trademark & Property of PrestaShop SA

         * PrestaShop Webservice Library

         * @package PrestaShopWebservice

         */



// Here we define constants /!\ You need to replace this parameters

        define('DEBUG', true); // Debug mode

        define('PS_SHOP_PATH', 'http://www.portucajabonita.com/'); // Root path of your PrestaShop store

        define('PS_WS_AUTH_KEY', 'AXYKN5WKRQJIQH2ENQRBMBIJH9R38F6U'); // Auth key (Get it in your Back Office)

        require_once('../vendor/PrestaShop-webservice-lib-master/PSWebServiceLibrary.php');

/*
// Here we make the WebService Call of customer

        try {

            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);

            // Here we set the option array for the Webservice : we want customers resources

            $opt['resource'] = 'customers';

            // We set an id if we want to retrieve infos from a customer

            $opt['id'] = 29; // cast string => int for security measures
            
            // Call
            $xml = $webService->get($opt);



            // Here we get the elements from children of customer markup which is children of prestashop root markup

            $resources = $xml->children()->children();
            
        } catch (PrestaShopWebserviceException $e) {

            // Here we are dealing with errors

            $trace = $e->getTrace();

            if ($trace[0]['args'][0] == 404)
                echo 'Bad ID';

            else if ($trace[0]['args'][0] == 401)
                echo 'Bad auth key';
            else
                echo 'Other error<br />' . $e->getMessage();
        }

*/
// Here we make the WebService Call of addresses

        try {

            $webService = new PrestaShopWebservice(PS_SHOP_PATH, PS_WS_AUTH_KEY, DEBUG);

            // Here we set the option array for the Webservice : we want customers resources

            //$opt['resource'] = 'addresses';
            //$opt['filter']['id_customer']=[29];
            
            $opt = array(
                'resource'=>'addresses',
                'display'=>'full',
                'filter[id_customer]'=>'[29]'
            );
            
            // We set an id if we want to retrieve infos from a customer

            //$opt['id_customer'] = 29; // cast string => int for security measures
            
            // Call
            $xml = $webService->get($opt);



            // Here we get the elements from children of customer markup which is children of prestashop root markup

            $addresses = $xml->children()->children();
            
        } catch (PrestaShopWebserviceException $e) {

            // Here we are dealing with errors

            $trace = $e->getTrace();

            if ($trace[0]['args'][0] == 404)
                echo 'Bad ID';

            else if ($trace[0]['args'][0] == 401)
                echo 'Bad auth key';
            else
                echo 'Other error<br />' . $e->getMessage();
        }







        echo '<table border="5">';

// if $resources is set we can lists element in it otherwise do nothing cause there's an error

        if (isset($resources)) {


            foreach ($resources as $key => $resource) {

                // Iterates on customer's properties

                echo '<tr>';

                echo '<th>' . $key . '</th><td>' . $resource . '</td>';
                echo '</tr>';
            }



            $cliente = array();
            $data_identidad = array('company', 'email');
            foreach ($data_identidad as $identidad) {
                $attrs = $resources->$identidad;
                foreach ($attrs as $attr_k => $attr_v) {
                    echo $attr_k . ": " . $attr_v . "\n";
                    $cliente = [$identidad => $attr_v];
                }
            }
            print_r($cliente);
        }

        echo '</table>';

        //$identidad = new Identidad();
        //$identidad->identidad_nombre = 'prueba';
        //$identidad->save();
        
 
        if (isset($addresses)) {


            foreach ($addresses as $key => $address) {

                // Iterates on customer's properties

                echo '<tr>';

                echo '<th>' . $key . '</th><td>' . $address . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';
        ?>
    </body></html>