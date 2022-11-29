<?php
class RentController implements IController, IManagementForm, IAction
{
    private $path = "rendered/rent/";
    private $config = null;
    private $maxRents = 3;
    public function __construct()
    {
        $this->config = Config::singleton();
        require "{$this->config->get("entities")}Rent.php";
        require "{$this->config->get("models")}RentModel.php";
        require "{$this->config->get("entities")}Client.php";
        require "{$this->config->get("models")}ClientModel.php";
        require "{$this->config->get("entities")}Copy.php";
        require "{$this->config->get("models")}CopyModel.php";
    }
    public function index()
    {
        $this->viewList();
    }
    public function viewCreate()
    {
        $vars = [];
        $vars["create"] = true;
        $model1 = new ClientModel();
        $vars['clients'] = $model1->get()->data;
        $model2 = new CopyModel();
        $vars['copies'] = $model2->get()->data;
        View::show("{$this->path}viewForm", $vars);
    }
    public function viewDetail()
    {
        $vars = [];
        $vars["id"] = $_REQUEST["acc"];
        $model1 = new Model();
        $vars['s'] = $model1->get()->data;
        $model2 = new Model();
        $vars['s'] = $model2->get()->data;
        View::show("{$this->path}viewForm", $vars);
    }
    public function viewList()
    {
        View::show("{$this->path}viewList");
    }
    public function actionList()
    {
        $arg = new stdClass();
        //*******************
        $m = new RentModel();
        $arg->filtro = @$_REQUEST['search'];
        $arg->paginator = null;
        $rcount = $m->getCount($arg->filtro)->cantidad;
        $arg->paginator = new Paginator($rcount, @$_REQUEST['p']);
        $r = $m->get($arg, false);
        $m->lazyLoad($r->data);
        if ($arg->paginator !== null) {
            $r->paginator = $arg->paginator->renderPaginator();
        }
        $r->count = $rcount;

        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
    public function actionListData()
    {
        //*******************
        $m = new RentModel();
        $rcount = $m->getCount()->cantidad;
        $r = $m->get();
        $r->count = $rcount;

        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
    public function actionDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $r = null;
            $m = new RentModel();
            $e = new Rent();
            $e->setId($_REQUEST["acc"]);
            $r = $m->getById($e);

            http_response_code($r->status);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($r);
        } else if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $this->actionUpdate();
        }
    }
    public function actionCreate()
    {
        $data = Utils::getParamsByBody();
        $e = new Rent();
        $e->serializeByObject($data);
        $m = new RentModel();

        $countUser = $m->getCountActiveRentByUser($e->getCli_id());
        if($countUser->cantidad >= $this->maxRents) {
            $response = new stdClass();
            http_response_code(412);
            header('Content-Type: application/json; charset=utf-8');
            $response->data = false;
            $response->message = "Cantidad maxima de rentas alcanzada, realice una devolucion para poder rentar";
            $response->status = 412;
            echo json_encode($response);
            return;
        }

        $currentDate = date("Y-m-d");
        $limitDate = date("Y-m-d", strtotime($currentDate."+ 3 days")); 

        $e->setRent_date($currentDate);
        $e->setLimit_date($limitDate);
        $e->setReturn_date(null);


        $r = $m->insert($e);

        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
        return;
    }
    public function actionDelete()
    {
        $m = new RentModel();
        $e = new Rent();
        $e->setId($_REQUEST["acc"]);

        $find = $m->getById($e);
        if(!$find->data) {
            http_response_code($find->status);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($find);
            return;
        }

        $r = $m->delete($e);
        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
    public function actionUpdate()
    {
        $data = Utils::getParamsByBody();
        $e = new Rent();
        $e->serializeByObject($data);
        $e->setId($_REQUEST["acc"]);

        $m = new RentModel();
        $find = $m->getById($e);
        if(!$find->data) {
            http_response_code($find->status);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($find);
            return;
        }

        $r = $m->update($e);
        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
}