<?php
class CopyController implements IController, IManagementForm, IAction
{
    private $path = "rendered/copy/";
    private $config = null;
    public function __construct()
    {
        $this->config = Config::singleton();
        require "{$this->config->get("entities")}Copy.php";
        require "{$this->config->get("models")}CopyModel.php";
        require "{$this->config->get("entities")}Film.php";
        require "{$this->config->get("models")}FilmModel.php";
    }
    public function index()
    {
        $this->viewList();
    }
    public function viewCreate()
    {
        $vars = [];
        $vars["create"] = true;
        $model1 = new FilmModel();
        $vars['s'] = $model1->get()->data;
        /*-$model2 = new Model();
        $vars['s'] = $model2->get()->data;*/
        View::show("{$this->path}viewForm", $vars);
    }
    public function viewDetail()
    {
        $vars = [];
        $vars["id"] = $_REQUEST["acc"];
        /*$model1 = new Model();
        $vars['s'] = $model1->get()->data;
        $model2 = new Model();
        $vars['s'] = $model2->get()->data;*/
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
        $m = new CopyModel();
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
        $m = new CopyModel();
        $rcount = $m->getCount()->cantidad;
        $r = $m->get();
        $r->count = $rcount;
        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }

    public function actionListDataByFilm()
    {
        //*******************
        $m = new CopyModel();
        $r = $m->getByFilmId(@$_REQUEST['paramId']);

        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }

    public function actionDetail()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $r = null;
            $m = new CopyModel();
            $e = new Copy();
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
        $e = new Copy();
        $e->serializeByObject($data);
        $m = new CopyModel();
        $r = $m->insert($e);
        http_response_code($r->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($r);
    }
    public function actionDelete()
    {
        $m = new CopyModel();
        $e = new Copy();
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
        $e = new Copy();
        $e->serializeByObject($data);
        $e->setId($_REQUEST["acc"]);

        $m = new CopyModel();
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