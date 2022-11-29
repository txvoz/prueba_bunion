<?php
class ClientController implements IController, IManagementForm, IAction
{
    private $path = "rendered/client/";
    private $config = null;
    public function __construct()
    {
        $this->config = Config::singleton();
        require "{$this->config->get("entities")}Client.php";
        require "{$this->config->get("models")}ClientModel.php";
    }
    public function index()
    {
        $this->viewList();
    }
    public function viewCreate()
    {
        $vars = [];
        $vars["create"] = true;
        View::show("{$this->path}viewForm", $vars);
    }
    public function viewDetail()
    {
        $vars = [];
        $vars["id"] = $_REQUEST["acc"];
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
        $m = new ClientModel();
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
        $m = new ClientModel();
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
            $m = new ClientModel();
            $e = new Client();
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
        $e = new Client();
        $e->serializeByObject($data);
        $m = new ClientModel();
        $r = $m->insert($e);

        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
    public function actionDelete()
    {
        $m = new ClientModel();
        $e = new Client();
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
        $e = new Client();
        $e->serializeByObject($data);
        $e->setId($_REQUEST["acc"]);

        $m = new ClientModel();
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