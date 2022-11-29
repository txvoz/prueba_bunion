<?php
class JwtController implements IController
{ 
    private $users = [];
    
    public function __construct() {
        $u1 = new stdClass();
        $u1->id = "12345";
        $u1->username = "admin";
        $u1->password = "admin123";
        $u1->token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NSIsIm5hbWUiOiJhZG1pbiIsImlhdCI6MTUxNjIzOTAyMn0.3683qT3MupTyzbRZDbw9JyM2u2OyMlxrs5_V_iJBS8I";

        $u2 = new stdClass();
        $u2->id = "54321";
        $u2->username = "txvoz";
        $u2->password = "txvoz123";
        $u2->token = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiI1NDMyMSIsIm5hbWUiOiJ0eHZveiIsImlhdCI6MTUxNjIzOTAyMn0.il0B7xfp8T1i-ggHfy0k-Z49FAi2oDvhgD1az937x1w";

        $this->users[] = $u1;
        $this->users[] = $u2;
    }

    /**
	 * @return mixed
	 */
	public function index() {
       $jData = file_get_contents("php://input");
        file_put_contents('C:/xampp/htdocs/bancounion_prueba/logs.txt', date('d-m-y h:i:s') . "::excecuteAuth:: " . $jData . "\n", FILE_APPEND);

        $data = Utils::getParamsByBody();

        $token = new stdClass();
        foreach($this->users as $user){
            if($user->username===$data->username && $user->password===$data->password) {
                
                $token->token = $user->token;

                http_response_code(200);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($token);
                return;
            }
        }

        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        $token->data = false;
        $token->message = "Unauthorized";
        echo json_encode($token);
        return;
    }


    public function validate() {

        $jData = file_get_contents("php://input");
        file_put_contents('C:/xampp/htdocs/bancounion_prueba/logs.txt', date('d-m-y h:i:s') . "::excecuteAuth:: " . $jData . "\n", FILE_APPEND);

        $data = Utils::getParamsByBody();

        $response = new stdClass();
        foreach($this->users as $user){
            if($user->token===$data->token) {
                $response->active = true;
                http_response_code(200);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($response);
                return;
            }
        }

        $response->active = false;
        $response->message = "Unauthorized";
       
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response);
        return;

    }

	

}

?>