<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(BASEPATH . '../application/libraries/Conekta.php');

class Charge extends CI_Controller {
            public function checkout()
            {

                        $response['responseStatus'] = "Not OK";

                        // private key of conekta dashboard
                        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
                        try {
                                    $charge = Conekta_Charge::create(array(
                                            "amount"=> 125000,
                                            "currency"=> "MXN",
                                            "description"=> "Galileo Tlahui",
                                            "reference_id"=> "Tlahui001 Galileo",
                                            "card"=> $this->input->post("token")
                                            //"tok_a4Ff0dD2xYZZq82d9"
                                    ));
                                    
                                    var_dump($charge);
                                    //echo json_encode($charge);


                        } catch (Conekta_Error $e) {
                                    echo $e->getMessage();
                                    //El pago no pudo ser procesado
                        }

            }

            public function confirm_payment()
            {
                        $body = @file_get_contents('php://input');

                        $event_json = json_decode($body);

                        if($event_json->type == 'charge.paid')
                        {
                               $response['id'] = $event_json->data->object->id;
                               $response['reference_id'] = $event_json->data->object->reference_id;
                               echo json_encode($response);
                        }



            }

            public function register_card()
            {

                        Conekta::setApiKey('key_Fq5U8GUU28hTqgxy4md4TQ');
                       try{
                              $customer = Conekta_Customer::create(array(
                                        "name"=> "Lews Therin",
                                        "email"=> "lews.therin@gmail.com",
                                        "phone"=> "55-5555-5555",
                                        "cards"=>  array()   //"tok_a4Ff0dD2xYZZq82d9"
                              ));

                            $card = $customer->createCard(array('token' => $this->input->post('token')));


                            echo $card->id;
                        }catch (Conekta_Error $e){
                                  echo $e->getMessage();
                                 //el cliente no pudo ser creado
                        }


            }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
