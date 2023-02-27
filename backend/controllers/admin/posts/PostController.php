<?php

namespace controllers\admin\posts;

use controllers\BaseController;
use Exception;
use controllers\TokenService;
use models\Post\PostStatus;

class PostController extends BaseController
{

    /**
     * @throws Exception
     */
    public function __construct($route)
    {
        parent::__construct($route);
        TokenService::checkAccessToken($this->route['attributes']['role']);
    }

    /**
     * @throws Exception
     */
    public function index()
    {
        $this->allowMethod();
    }

    /**
     * @throws Exception
     */
    public function getPostStatuses(): void
    {
        $this->allowMethod();

        $postStatusesModel = new PostStatus();

        echo jsonWrite($postStatusesModel->all());
    }

    /**
     * @throws Exception
     */
    public function store()
    {
        $this->allowMethod('post');

        dd(1, $_POST, $_FILES);

    }
}